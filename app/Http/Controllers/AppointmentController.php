<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Jobs\SendStatusMail;
use Illuminate\Support\Facades\Mail;
use App\Mail\AppointmentStatusUpdated;
use App\Models\UserSession;
use App\Models\UserPackage;
use App\Notifications\AppointmentUpdateNotification;
use App\Events\PostCreateNoti;
use App\Models\AppointmentChange;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use App\Models\GoogleCredential;
use App\Models\User;
use Google_Client;
use App\Jobs\SendUpdateMail;
use App\Services\GoogleCalendarService;

class AppointmentController extends Controller
{
    protected $googleCalendarService;

    public function __construct(GoogleCalendarService $googleCalendarService)
    {
        $this->googleCalendarService = $googleCalendarService;
    }

    public function index(Request $request)
    {
        $appointment = Appointment::with('user','service.category', 'staff.user', 'slot', 'payment')->get();
        return response()->json($appointment);
    }
    public function getAppointment(Request $request)
    {
        $appointment = Appointment::findOrFail($request->id);
        return response()->json($appointment);
    }
    // public function edit(Request $request)
    // {
    //     $appointment = Appointment::findOrFail($request->id);
    //     $appointment->status = $request->status;
    //     $appointment->save();

    //     $userEmail = $appointment->email;
    //     $staffEmail = $appointment->staff->user->email;
    //     $adminEmail = 'hw13604@gmail.com';


    //     // Email Work
    //     SendStatusMail::dispatch($userEmail, $appointment, 'user');
    //     SendStatusMail::dispatch($staffEmail, $appointment, 'staff');
    //     SendStatusMail::dispatch($adminEmail, $appointment, 'admin');

    //     return redirect()->back()->with('success', 'Status updated successfully!');
    // }

    public function edit(Request $request)
    {
        $appointment = Appointment::findOrFail($request->id);

        // Update the appointment status
        $appointment->status = $request->status;

        // If the current slot is marked as completed, increment completed slots
        if ($request->status == 'completed') {
            // $appointment->completed_slots += 1;

            // $userSession = UserSession::updateOrCreate(
            //     ['user_id' => $appointment->user_id],
            //     [
            //         'user_id' => $appointment->user_id,
            //         'service_id' => $appointment->service_id,
            //         'sessions' => $appointment->total_slots-$appointment->completed_slots,
            //     ]
            // );

            // If the appointment is not fully completed, allow the user to select the next slot later
            if ($appointment->completed_slots < $appointment->total_slots) {
                $appointment->status = 'confirmed'; // Set status to indicate waiting for the next slot selection
                // $appointment->status = 'awaiting_next_slot'; // Set status to indicate waiting for the next slot selection
            } else {
                // Mark as fully completed if all slots are done
                $appointment->status = 'fully_completed';
            }
        }
        if ($request->status == 'canceled') {
            if($appointment->completed_slots == 0){
                // $appointment->completed_slots = $appointment->total_slots;
            }else{
                $appointment->completed_slots -= 1;
            }

            $userSessions = UserSession::where('user_id',$appointment->user_id)->first();
            $sessions = $userSessions->sessions+1 ?? 0;
            $userSession = UserSession::updateOrCreate(
                ['user_id' => $appointment->user_id],
                [
                    'user_id' => $appointment->user_id,
                    'service_id' => $appointment->service_id,
                    'sessions' => $sessions,
                ]
            );

            $UserPackage = UserPackage::where('user_id', $appointment->user_id)
                ->where('service_id', $appointment->service_id)
                ->where('id', $appointment->package_id)
                ->first();

                if ($UserPackage) {
                    $UserPackage->used_sessions = $UserPackage->used_sessions - 1;
                    $UserPackage->save();

                    if(($UserPackage->sessions != $UserPackage->used_sessions) && ($UserPackage->status == 'inactive')){
                        $UserPackage->status = 'active';
                        $UserPackage->save();
                    }
                }
        }

        if($appointment->completed_slots == $appointment->total_slots){
            $appointment->active = '0';
        }else{
            $appointment->active = '1';
        }

        $appointment->save();

        // Send emails notifying user, staff, and admin
        $userEmail = $appointment->email;
        $staffEmail = $appointment->staff->user->email;
        $adminEmail = 'hw13604@gmail.com';

        // $adminEmail = 'hw13604@gmail.com';


        SendStatusMail::dispatch($userEmail, $appointment, 'user');
        SendStatusMail::dispatch($staffEmail, $appointment, 'staff');
        SendStatusMail::dispatch($adminEmail, $appointment, 'admin');

        return redirect()->back()->with('success', 'Status updated successfully!');
    }

    public function change(Request $request)
    {
        $appointment = Appointment::findOrFail($request->id);
        return response()->json($appointment);
    }

    public function reschedule(Request $request)
    {
        try {
            // Check for tokens in the database
            $credentials = GoogleCredential::first(); // Assuming only one set of credentials
            if (!$credentials || empty($credentials->access_token)) {
                // return redirect()->route('auth.google');
            }

            // Handle token refresh if expired
            $client = new Google_Client();
            $client->setClientId($credentials->client_id);
            $client->setClientSecret($credentials->client_secret);
            $client->setAccessToken($credentials->access_token);

            if ($client->isAccessTokenExpired()) {
                $refreshToken = $credentials->refresh_token;
                if ($refreshToken) {
                    $client->fetchAccessTokenWithRefreshToken($refreshToken);
                    // Store the refreshed token back in the database
                    $credentials->access_token = $client->getAccessToken()['access_token'];
                    $credentials->save();
                }
            }

            $lockKey = "lock:reschedule:{$request->slot_id}:{$request->appointment_date}:{$request->staff_id}";
            $lockDuration = 30; // Lock duration in seconds
            $lock = Cache::lock($lockKey, $lockDuration);

            if (!$lock->get()) {
                return response()->json(['success' => false, 'message' => 'This slot is already being booked by another user'], 429);
            }

            DB::beginTransaction();

            // Check if the slot is already booked
            $testAppointment = Appointment::where('slot_id', $request->slot_id)
                ->where('appointment_date', $request->appointment_date)
                ->where('staff_id', $request->staff_id)
                ->where('status', '!=', 'canceled')
                ->lockForUpdate()
                ->first();

            if ($testAppointment) {
                DB::rollBack();
                return response()->json(['success' => false, 'message' => 'Slot is full'], 409);
            }

            // Update the appointment with the new slot and date
            $appointment = Appointment::find($request->id);

            if (!$appointment) {
                DB::rollBack();
                return response()->json(['success' => false, 'message' => 'Appointment not found'], 404);
            }

            // Save the change in `appointment_changes`
            AppointmentChange::create([
                'appointment_id' => $appointment->id,
                'previous_date' => $request->previous_date,
                'new_date' => $request->appointment_date,
                'old_slot_id' => $request->old_slot_id,
                'new_slot_id' => $request->slot_id,
                'changed_by' => auth()->id(),
                'reason' => $request->reason,
            ]);

            $appointment->update([
                'slot_id' => $request->slot_id,
                'appointment_date' => $request->appointment_date,
                'status' => 'rescheduled',
                'is_rescheduled' => true
            ]);

            if($appointment->google_event_id){

                if ($credentials->client_id && $credentials->client_secret) {
                        // ------------------- <-- Google Calendar Event --> ------------------- \\

                        // Update the Google Calendar event for this appointment
                        $calendarEventResponse = $this->updateGoogleCalendarEvent($appointment);

                        // Handle any redirect response from the calendar service
                        if ($calendarEventResponse instanceof \Illuminate\Http\RedirectResponse) {
                            DB::rollBack();
                        return $calendarEventResponse;
                    }
                }
            }

            $adminUser = User::role('admin')->first();
                if ($appointment->user != null) {
                    // Send notification
                    $appointment->user->notify(new AppointmentUpdateNotification($appointment));
                    $appointment->staff->user->notify(new AppointmentUpdateNotification($appointment));
                    $adminUser->notify(new AppointmentUpdateNotification($appointment));
                    event(new PostCreateNoti($appointment));
                }

                 // Prepare email data
                 $userEmail = $appointment->email;
                 $staffEmail = $appointment->staff->user->email;
                 $adminEmail = 'hw13604@gmail.com';


                 // Send email
                if ($userEmail) {
                    SendUpdateMail::dispatch($userEmail, $appointment, 'user');
                }
                SendUpdateMail::dispatch($staffEmail, $appointment, 'staff');
                SendUpdateMail::dispatch($adminEmail, $appointment, 'admin');
            
            DB::commit();

            return response()->json(['success' => true, 'message' => 'Appointment rescheduled successfully']);
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Rescheduling failed: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'An error occurred', 'error' => $e->getMessage()], 500);
        } finally {
            // Release the lock in the finally block
            if ($lock) {
                $lock->release();
            }
        }
    }

    private function updateGoogleCalendarEvent($appointment)
    {
        try {
            \Log::info('Updating Google Calendar event for appointment ID: ' . $appointment->id);
            return $this->googleCalendarService->updateEvent($appointment);
        } catch (\Exception $e) {
            \Log::error('Google Calendar update failed: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Google Calendar update failed', 'error' => $e->getMessage()], 500);
        }
    }


}
