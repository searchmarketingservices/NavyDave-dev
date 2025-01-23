<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\Payment;
use App\Models\Appointment;
use App\Models\Subscriber;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Models\Service;
use App\Models\UserSession;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use App\Models\GoogleCredential;
use Google_Client;
use App\Services\GoogleCalendarService;
use App\Notifications\AppointmentCreateNotification;
use App\Events\PostCreateNoti;
use App\Models\User;
use App\Notifications\AppointmentUpdateNotification;
use App\Jobs\SendUpdateMail;
use App\Models\AppointmentChange;

class UserAuthController extends Controller
{

    protected $googleCalendarService;

    public function __construct(GoogleCalendarService $googleCalendarService)
    {
        $this->googleCalendarService = $googleCalendarService;
    }

    public function dashboard()
    {
        $user = auth()->user()->id;
        $approvedAppointments = Appointment::where('user_id', $user)->where('status', 'confirmed')->count();
        $totalAppointments = Appointment::where('user_id', $user)->count();
        $pendingAppointments = Appointment::where('user_id', $user)->where('status', 'pending')->count();
        $appointments = Appointment::where('user_id', $user)->with('slot', 'payment')->orderBy('id', 'desc')->take(10)->get();

        // $remainingSlots = 0;

        // Remaining Slots
        $totalUserAppointments = Appointment::where('user_id', $user)->select('total_slots', 'completed_slots')->get();

        // foreach ($totalUserAppointments as $totalUserAppointment) {
        //     $remainingSlots += ($totalUserAppointment->total_slots - $totalUserAppointment->completed_slots);
        // }

        $userSession = UserSession::where('user_id', $user)->first();

        if ($userSession) {
            $remainingSlots = $userSession->sessions;
        } else {
            $remainingSlots = 0;
        }

        //Remaining Slots
        return view('dashboard.user.dashboard', compact('appointments', 'approvedAppointments', 'totalAppointments', 'pendingAppointments', 'remainingSlots'));
    }

    public function calendar()
    {
        $user = auth()->user()->id;
        $appointments = Appointment::where('user_id', $user)->with('service.category', 'staff.user', 'slot', 'payment')->get();
        return view('dashboard.user.calendar.index', compact('appointments'));
    }

    public function staff()
    {
        return view('dashboard.user.staff.index');
    }

    public function community()
    {
        return view('dashboard.admin.community.index');
    }

    public function getAppointment(Request $request)
    {
        $user = auth()->user()->id;
        $appointment = Appointment::where('user_id', $user)->with('service.category', 'staff.user', 'slot', 'payment')->get();
        return response()->json($appointment);
    }
    public function getUserAppointment(Request $request)
    {
        $user = auth()->user()->id;
        $appointment = Appointment::where('user_id', $user)->with('service.category', 'staff.user', 'slot', 'payment')->get();
        return response()->json($appointment);
    }

    public function appointment()
    {
        return view('dashboard.user.appointment.index');
    }

    public function profile()
    {
        $user = auth()->user();
        return view('dashboard.user.profile.profile', compact('user'));

    }

    public function profileupdate(Request $request)
    {
        // Retrieve the authenticated user
        $user = auth()->user();
        // Validate the incoming request
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:15',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'password' => 'nullable|string|min:8',
            'zipcode' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Update the user's profile
        $user->update([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'address' => $request->input('address'),
            'city' => $request->input('city'),
            'zipcode' => $request->input('zipcode'),
            'state' => $request->input('state'),
        ]);

        // Handle password update
        if ($request->input('password')) {
            $user->password = Hash::make($request->input('password'));
            $user->save();
        }

        if ($request->hasFile('image')) {
            // Check if the user has an old image and delete it
            if ($user->image && Storage::exists('public/' . $user->image)) {
                Storage::delete('public/' . $user->image);
            }


            $extension = $request->file('image')->getClientOriginalExtension();
            $uniqueName = 'UserProfile' . Str::random(40) . '.' . $extension;
            $request->file('image')->storeAs('public', $uniqueName);

            // Update the user's image in the database
            $user->image = $uniqueName;
            $user->save();
        }

        // Redirect back with a success message
        return redirect()->route('user.profile')->with('success', 'Profile updated successfully.');
    }
    public function subscribe(Request $request)
    {
        // Validate the email
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:subscribers,email',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Save the email to the subscribers table
        $subscriber = new Subscriber();
        $subscriber->email = $request->input('email');
        $subscriber->save();

        // Redirect back with a success message
        return redirect()->back()->with('success', 'You have successfully subscribed to the newsletter!');
    }

    public function videoTutorial()
    {
        return view("dashboard.user.videoTutorial");
    }

    public function editAppointment(Request $request)
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
