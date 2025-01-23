<?php

namespace App\Http\Controllers;

use App\Jobs\SendMessage;
use App\Models\Blog;
use App\Models\Staff;
use App\Notifications\AppointmentCreateNotification;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Service;
use App\Models\ServiceAssign;
use App\Models\Slot;
use App\Models\Appointment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\AppointmentCreated;
use App\Jobs\SendMail;
use Illuminate\Support\Facades\Log;
use Stripe\Stripe;
use Session;
use Stripe\StripeClient;
use App\Models\Payment;
use Validator;
use Illuminate\Support\Facades\Crypt;
use App\Models\AppointmentSlot;
use App\Models\User;
use App\Events\PostCreateNoti;
use Spatie\Permission\Models\Role;
use App\Services\GoogleCalendarService;
use Google_Client;
use App\Models\GoogleCredential;
use App\Models\UserSession;
use App\Models\RestrictSlot;
use App\Models\Discount;
use Illuminate\Support\Facades\Cache;
use App\Models\UserPackage;


class GuestController extends Controller
{
    protected $googleCalendarService;

    public function __construct(GoogleCalendarService $googleCalendarService)
    {
        $this->googleCalendarService = $googleCalendarService;
    }

    public function home()
    {
        $today = now();
        $services = Service::with('category')->orderBy('id', 'desc')->where('is_admin', 0)->take(2)->get();

        foreach ($services as $s) {
            $discount = Discount::where('status', 1)
                ->where('service_id', $s->id)
                ->whereDate('start_date', '<=', $today)
                ->whereDate('expired_date', '>=', $today)
                ->first();

            if ($discount) {
                $s->is_discount = true;
                $s->discount = $discount->percentage;
                $s->original_price = $s->price;
                $s->price = $s->price - ($s->price * $discount->percentage / 100);
            } else {
                $s->is_discount = false;
                $s->discount = 0;
                $s->original_price = $s->price;
            }
        }

        return view('guest.home', compact('services'));
    }
    public function about()
    {
        return view('guest.about');
    }
    public function pricing()
    {
        $today = now();
        $services = Service::with('category')->where('is_admin', 0)->orderBy('id', 'desc')->get();

        foreach ($services as $s) {
            $discount = Discount::where('status', 1)
                ->where('service_id', $s->id)
                ->whereDate('start_date', '<=', $today)
                ->whereDate('expired_date', '>=', $today)
                ->first();

            if ($discount) {
                $s->is_discount = true;
                $s->discount = $discount->percentage;
                $s->original_price = $s->price;
                $s->price = $s->price - ($s->price * $discount->percentage / 100);
            } else {
                $s->is_discount = false;
                $s->discount = 0;
                $s->original_price = $s->price;
            }
        }
        return view('guest.pricing', compact('services'));
    }

    public function contact()
    {
        return view('guest.contact');
    }
    public function contactStore(Request $request)
    {
        // Validate inputs
        $validator = Validator::make($request->all(), [
            'fullname' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:5000',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Send email
        $data = [
            'fullname' => $request->fullname,
            'email' => $request->email,
            'subject' => $request->subject,
            'message' => $request->message,
        ];

        // Send email
        $adminEmail = 'hw13604@gmail.com';

        SendMessage::dispatch($adminEmail, $data);

        return redirect()->back()->with('success', 'Your message has been sent successfully.');
    }
    // public function appointment()
    // {
    //     $categories = Category::all();
    //     $user = auth()->user();

    //     if ($user) {

    //         $remaining_slots = 0;
    //         // $appointments = Appointment::where('user_id', $user->id)->select('id', 'last_name', 'phone', 'total_slots', 'completed_slots', 'service_id', 'staff_id')->first();

    //         $appointments = Appointment::where('user_id', $user->id)
    //             ->whereColumn('completed_slots', '!=', 'total_slots') // Correct comparison
    //             ->select('id', 'last_name', 'phone', 'total_slots', 'completed_slots', 'service_id', 'staff_id')
    //             ->first();

    //         if ($appointments && $appointments->total_slots > $appointments->completed_slots) {
    //             $remaining_slots = ($appointments->total_slots - $appointments->completed_slots);
    //             $service_id = $appointments->service_id;
    //             $staff_id = $appointments->staff_id;
    //             $appointmentId = $appointments->id;
    //             $lastName = $appointments->last_name;
    //             $phone = $appointments->phone;
    //         } else {
    //             $service_id = 0;
    //             $staff_id = 0;
    //             $remaining_slots = 0;
    //             $appointmentId = 0;
    //             $lastName = '';
    //             $phone = '';
    //         }

    //         return view('guest.appointment')->with(compact('lastName', 'phone', 'categories', 'user', 'remaining_slots', 'service_id', 'staff_id', 'appointmentId'));
    //     }

    //     $service_id = 0;
    //     $staff_id = 0;
    //     $remaining_slots = 0;
    //     $appointmentId = 0;
    //     $lastName = '';
    //     $phone = '';
    //     return view('guest.appointment')->with(compact('lastName', 'phone', 'categories', 'user', 'remaining_slots', 'service_id', 'staff_id', 'appointmentId'));
    // }
    public function appointment()
    {
        $categories = Category::all();
        $user = auth()->user();

        if ($user) {

            // $remaining_slots = 0;
            $userSession = UserSession::where('user_id', $user->id)->first();
            if ($userSession) {
                $remaining_slots = $userSession->sessions;
            } else {
                $remaining_slots = 0;
            }


            // $appointments = Appointment::where('user_id', $user->id)->select('id', 'last_name', 'phone', 'total_slots', 'completed_slots', 'service_id', 'staff_id')->first();

            $appointments = Appointment::where('user_id', $user->id)
                ->whereColumn('completed_slots', '!=', 'total_slots') // Correct comparison
                // ->where('status', '!=', 'canceled')
                ->where('active',  '1')
                ->where('status', '!=', 'completed')
                ->select('id', 'last_name', 'phone', 'total_slots', 'completed_slots', 'service_id', 'staff_id')
                ->latest()
                ->first();

            if ($appointments && $appointments->total_slots > $appointments->completed_slots) {
                // $remaining_slots = ($appointments->total_slots - $appointments->completed_slots);
                $service_id = $appointments->service_id;
                $staff_id = $appointments->staff_id;
                $appointmentId = $appointments->id;
                $lastName = $appointments->last_name;
                $phone = $appointments->phone;
            } else {
                if ($userSession && $userSession->sessions > 0) {
                    $service_id = $userSession->service_id ?? 0;
                    $staff_id = $userSession->staff_id ?? 0;
                } else {
                    $service_id = 0;
                    $staff_id = 0;
                }
                // $remaining_slots = 0;
                $appointmentId = 0;
                $lastName = '';
                $phone = '';
            }

            // dd($appointmentId);
            // dd($service_id);
            return view('guest.appointment')->with(compact('lastName', 'phone', 'categories', 'user', 'remaining_slots', 'service_id', 'staff_id', 'appointmentId'));
        }

        $service_id = 0;
        $staff_id = 0;
        $remaining_slots = 0;
        $appointmentId = 0;
        $lastName = '';
        $phone = '';
        return view('guest.appointment')->with(compact('lastName', 'phone', 'categories', 'user', 'remaining_slots', 'service_id', 'staff_id', 'appointmentId'));
    }
    public function blogs()
    {
        $blogs = Blog::all();
        return view('guest.blogs', compact('blogs'));
    }
    public function blogDetails($id)
    {
        $Blog = Blog::findOrFail($id);
        $blogs = Blog::all();
        return view('guest.blog-details')->with(compact('blogs', 'Blog'));
    }
    public function faq()
    {
        return view('guest.faq');
    }
    public function getServices($id)
    {
        $today = now();

        if ($id == 0) {
            $service = Service::all();
            foreach ($service as $s) {
                $discount = Discount::where('status', 1)
                    ->where('service_id', $s->id)
                    ->whereDate('start_date', '<=', $today)
                    ->whereDate('expired_date', '>=', $today)
                    ->first();

                if ($discount) {
                    $s->is_discount = true;
                    $s->discount = $discount->percentage;
                    $s->original_price = $s->price;
                    $s->price = $s->price - ($s->price * $discount->percentage / 100);
                } else {
                    $s->is_discount = false;
                    $s->discount = 0;
                    $s->original_price = $s->price;
                }
            }
            return response()->json($service);
        }

        $service = Service::where('category_id', $id)->get();

        foreach ($service as $s) {
            $discount = Discount::where('status', 1)
                ->where('service_id', $s->id)
                ->whereDate('start_date', '<=', $today)
                ->whereDate('expired_date', '>=', $today)
                ->first();

            if ($discount) {
                $s->is_discount = true;
                $s->discount = $discount->percentage;
                $s->original_price = $s->price;
                $s->price = $s->price - ($s->price * $discount->percentage / 100);
            } else {
                $s->is_discount = false;
                $s->discount = 0;
                $s->original_price = $s->price;
            }
        }

        return response()->json($service);
    }

    public function getStaff($id)
    {
        $staffAssignments = ServiceAssign::where('service_id', $id)->pluck('staff_id');
        $staffs = Staff::with('user')
            ->whereIn('id', $staffAssignments)
            ->where('status', 'Active')
            ->get();

        return response()->json($staffs);
    }

    public function getSlots(Request $request)
    {
        $todayName = date('l');
        $now = now()->format('Y-m-d');

        $slotIds = Appointment::where('appointment_date', $now)->where('status', '!=', 'canceled')->pluck('slot_id');

        $slots = Slot::where('staff_id', $request->staff_id)->where('service_id', $request->service_id)->where('available_on', $todayName)->get();

        $appointments = Appointment::with('slot')
            ->where('staff_id', $request->staff_id)
            ->where('appointment_date', $now)
            ->get();

        foreach ($slots as $slot) {
            $slot->is_booked = $slotIds->contains($slot->id) ? true : false;

            foreach ($appointments as $a) {
                if ($slot->available_from == $a->slot->available_from) {
                    $slot->is_booked = true;
                }
            }
        }

        $restrict_slot = RestrictSlot::where('date', $now)->first();
        if ($restrict_slot) {
            // foreach ($slots as $slot) {
            //     $slot->is_booked = true;
            // }
            $slots = [];
        }

        return response()->json($slots);
    }
    // public function getSlotsForDate(Request $request)
    // {
    //     $dayName = date('l', strtotime($request->date));

    //     $data = $request->date;
    //     $data = date('Y-m-d', strtotime($data));
    //     $slotIds = Appointment::where('appointment_date', $data)->where('status', '!=', 'canceled')->pluck('slot_id');

    //     $slots = Slot::where('staff_id', $request->staff_id)->where('service_id', $request->service_id)->where('available_on', $dayName)->get();

    //     $appointmnet = Appointment::with('slot')->where('staff_id',$request->staff_id)->where('appointment_date', $data)->get();
    //     foreach ($slots as $slot) {
    //         $slot->is_booked = $slotIds->contains($slot->id) ? true : false;
    //         foreach($appointmnet as $a){
    //             if($slot->available_from == $a->slot->available_from){
    //                 $slot->is_booked = true;
    //             }
    //         }
    //     }
    //     return response()->json($slots);
    // }

    public function getSlotsForDate(Request $request)
    {
        $dayName = date('l', strtotime($request->date));

        // Convert the input date into Y-m-d format
        $data = date('Y-m-d', strtotime($request->date));

        // Retrieve the slot IDs for appointments on the selected date (non-canceled)
        $slotIds = Appointment::where('appointment_date', $data)
            ->where('staff_id', $request->staff_id) // Only for the same staff
            ->where('status', '!=', 'canceled')
            ->pluck('slot_id');

        // Retrieve slots for the selected staff, service, and day of the week
        $slots = Slot::where('staff_id', $request->staff_id)
            ->where('service_id', $request->service_id)
            ->where('available_on', $dayName)
            ->get();

        // Retrieve appointments with slot info for the same date and staff
        $appointments = Appointment::with('slot')
            ->where('staff_id', $request->staff_id)
            ->where('appointment_date', $data)
            ->where('status', '!=', 'canceled')
            ->get();

        // Mark each slot as booked based on previous appointments or overlapping available_from time
        foreach ($slots as $slot) {
            // First check if the slot is booked by slot_id
            $slot->is_booked = $slotIds->contains($slot->id);

            // Further check if any appointment has a matching available_from time
            foreach ($appointments as $appointment) {
                if($appointment->slot){
                    if ($slot->available_from == $appointment->slot->available_from) {
                        $slot->is_booked = true;
                        break; // No need to check further once it's marked as booked
                    }
                }
            }
        }

        $restrict_slot = RestrictSlot::where('date', $data)->first();
        if ($restrict_slot) {
            $slots = [];
        }

        return response()->json($slots);
    }


    public function appointmentCreate(Request $request)
    {
        $validated = $request->validate([
            'service_id' => 'required|integer',
            'staff_id' => 'required|integer',
            'slot_id' => 'required|integer',
            'appointment_date' => 'required|date',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string',
            'location' => 'nullable|string|max:255',
            'note' => 'nullable|string',
        ]);

        DB::beginTransaction();

        try {
            // Retrieve the price from the Service model
            $service = Service::findOrFail($validated['service_id']);

            $discount = Discount::where('status', 1)
                ->where('service_id', $service->id)
                ->whereDate('start_date', '<=', now())
                ->whereDate('expired_date', '>=', now())
                ->first();

            if ($discount) {
                $validated['price'] = $service->price - ($service->price * ($discount->percentage / 100));
            }else {
                $validated['price'] = $service->price;
            }

            // Create the appointment
            $data = Appointment::create($validated);

            // Load the appointment with relationships
            $appointment = Appointment::with('slot', 'staff.user', 'service')->findOrFail($data->id);

            // Prepare email data
            $userEmail = $validated['email'];
            $staffEmail = $appointment->staff->user->email;
            $adminEmail = 'hw13604@gmail.com';


            // Send email
            if ($userEmail) {
                SendMail::dispatch($userEmail, $appointment, 'user');
            }
            SendMail::dispatch($staffEmail, $appointment, 'staff');
            SendMail::dispatch($adminEmail, $appointment, 'admin');

            // Commit the transaction
            DB::commit();
            return response()->json(['success' => true, 'message' => 'Appointment created successfully', 'data' => $appointment]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Failed to create appointment', 'error' => $e->getMessage()], 500);
        }
    }

    public function mailCheck()
    {

        try {
            $appointment = Appointment::with('slot', 'staff.user', 'service')->first();

            // Send email

            SendMail::dispatch("talharao997az@gmail.com", $appointment, 'user');
            SendMail::dispatch("hw13604@gmail.com", $appointment, 'user');

            return response()->json(['success' => true, 'message' => 'Appointment created successfully', 'data' => $appointment]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Failed to create appointment', 'error' => $e->getMessage()], 500);
        }
    }


    public function appointmentStripe(Request $request)
    {
        // dd($request->all());
        $lockKey = 'lock:appointment:' . $request->slot_id . ':' . $request->appointment_date . ':' . $request->staff_id;
        $lockDuration = 30;

        $validator = Validator::make($request->all(), [
            'service_id' => 'required|integer',
            'staff_id' => 'required|integer',
            'slot_id' => 'required|integer',
            'appointment_date' => 'required|date',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|nullable|email|max:255',
            'phone' => 'required|nullable|string',
            'location' => 'required|nullable|string|max:255',
            'note' => 'nullable|string',
            'user_id' => 'nullable',
        ]);

        // Set custom attribute names
        $validator->setAttributeNames([
            'staff_id' => 'Staff',
            'slot_id' => 'Slot',
        ]);

        $lock = Cache::lock($lockKey, $lockDuration);

        if (!$lock->get()) {
            return response()->json(['success' => false, 'message' => 'This slot is already being booked by another user'], 429);
        }
        
        $testAppointment = Appointment::where('slot_id', $request->slot_id)
        ->where('appointment_date', $request->appointment_date)
        ->where('staff_id' , $request->staff_id)
        ->where('status', '!=', 'canceled')
        ->lockForUpdate()
        ->first();
        
        if(isset($testAppointment)) {
            return response()->json(['success' => false, 'message' => 'This Slot is already Booked'], 500);
        }
        

        // Validate the request
        $validated = $validator->validate();

        if (isset($validated['phone'])) {
            // Check if the phone number does not start with +1
            if (!str_starts_with($validated['phone'], '+1')) {
                // Prepend +1 to the phone number
                $validated['phone'] = '+1 ' . $validated['phone'];
            }
        }

        DB::beginTransaction();

        try {
            // Retrieve the price from the Service model
            $service = Service::findOrFail($validated['service_id']);

            // Discount Work
            $discount = Discount::where('status', 1)
                ->where('service_id', $service->id)
                ->whereDate('start_date', '<=', now())
                ->whereDate('expired_date', '>=', now())
                ->first();

            if ($discount) {
                $validated['price'] = $service->price - ($service->price * ($discount->percentage / 100));
            }else {
                $validated['price'] = $service->price;
            }

            // ------------------- <-- Stripe Payment --> ------------------- \\

            $total = $validated['price'];
            $service = Service::findOrFail($validated['service_id']);

            Session::put('SessionData', $validated);

            $stripeSecretKey = env('STRIPE_SECRET_KEY', 'sk_test_51LkfAQH65lvSBiDK232wi93QAEfeM0XgS8s62kRse0LGoKn2pHxZhMu23pA4w5CyqeR7jaichrCsgnSQdz5S7NPD00GOpROogE');
            $stripe = new StripeClient([
                'api_key' => $stripeSecretKey,
            ]);

            $checkoutSession = $stripe->checkout->sessions->create([
                'success_url' => route('payment.success'),
                'cancel_url' => route('payment.fail'),
                'payment_method_types' => ['card'],
                'mode' => 'payment',
                'line_items' => [
                    [
                        'price_data' => [
                            'currency' => 'USD',
                            'unit_amount' => $total * 100,
                            'product_data' => [
                                'name' => $service->name,
                                'description' => 'Service charge',
                            ],
                        ],
                        'quantity' => 1,
                    ],
                ],
                'customer_email' => $validated['email'] ?? 'default@example.com',
            ]);

            Session::put('stripe_checkout_id', $checkoutSession->id);

            // Commit the transaction
            DB::commit();
            // return redirect()->away($checkoutSession->url);
            // return redirect($checkoutSession->url);
            return response()->json(['success' => true, 'message' => 'Payment successful', 'data' => $checkoutSession->url]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Failed to create appointment', 'error' => $e->getMessage()], 500);
        }
    }

    public function nextSlot(Request $request)
    {
        // dd($request->all());
        $testAppointment = Appointment::where('slot_id', $request->slot_id)
        ->where('appointment_date', $request->appointment_date)
        ->where('staff_id' , $request->staff_id)
        ->where('status', '!=', 'canceled')
        ->lockForUpdate()
        ->first();
        if(isset($testAppointment)) {
            return response()->json(['success' => false, 'message' => 'Slot is full', 'error' => 'Slot is full'], 500);
        }

        if ($request->appointment_id == 0) {
            // Begin Transaction
            DB::beginTransaction();

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
            try {
                $UserPackageNew = UserPackage::where('user_id', $request->user_id)
                ->where('status', 'active')
                ->first();


                // $appointment = Appointment::with('slot')->findOrFail($request->appointment_id);
                if(isset($UserPackageNew)) {
                    $serviceN = Service::findOrFail($UserPackageNew->service_id);
                }else{
                    $serviceN = Service::findOrFail($request->service_id);
                }


                // Discount Work
                $discount = Discount::where('status', 1)
                ->where('service_id', $serviceN->id)
                ->whereDate('start_date', '<=', now())
                ->whereDate('expired_date', '>=', now())
                ->first();

                if ($discount) {
                    $price = $serviceN->price - ($serviceN->price * ($discount->percentage / 100));
                }else {
                    $price = $serviceN->price;
                }

                $userN = User::find($request->user_id);

                $appointmentNew = Appointment::create([
                    'service_id' => $serviceN->id,
                    'user_id' => $request->user_id,
                    'staff_id' => $request->staff_id,
                    'slot_id' => $request->slot_id,
                    'total_slots' => $UserPackageNew->sessions,
                    // 'total_slots' => $serviceN->slots,
                    'completed_slots' => 1,
                    'appointment_date' => $request->appointment_date,
                    'first_name' => $userN->name,
                    'last_name' => $userN->last_name,
                    'email' => $userN->email,
                    'phone' => $userN->phone,
                    'location' => $request->location,
                    'price' => $price,
                    'note' => $request->note,
                    'status' => 'confirmed',
                ]);

                if($appointmentNew->total_slots == 1) {
                    $appointmentNew->active = '0';
                }else{
                    $appointmentNew->active = '1';
                }

                $appointmentNew->save();

                $appointment = Appointment::with('slot')->findOrFail($appointmentNew->id);

                if ($appointment->completed_slots == $appointment->total_slots) {
                    if($appointment->status != 'rescheduled') {
                        $appointment->status = 'confirmed';
                    }
                } else {
                    if($appointment->status != 'rescheduled') {
                        $appointment->status = 'confirmed';
                    }
                }

                $appointment->save();

                $userSessions = UserSession::where('user_id', $appointment->user_id)->first();
                $sessions = $userSessions->sessions - 1 ?? 0;
                $userSession = UserSession::updateOrCreate(
                    ['user_id' => $appointment->user_id],
                    [
                        'user_id' => $appointment->user_id,
                        'service_id' => $appointment->service_id,
                        'sessions' => $sessions,
                        'staff_id' => $appointment->staff_id,
                    ]
                );
                
                $UserPackage = UserPackage::where('user_id', $appointment->user_id)
                ->where('service_id', $appointment->service_id)
                ->where('status', 'active')
                ->first();

                if ($UserPackage) {
                    $UserPackage->used_sessions = $UserPackage->used_sessions + 1;
                    $UserPackage->save();
                }

                if ($UserPackage && $UserPackage->used_sessions == $UserPackage->sessions) {
                    $UserPackage->status = 'inactive';
                    $UserPackage->save();
                }

                $appointment->package_id = $UserPackage->id ?? null;
                $appointment->save();

                $newAppointment = Appointment::with('slot', 'staff.user', 'service', 'user')->findOrFail($appointmentNew->id);

                $adminUser = User::role('admin')->first();

                // ------------------- <-- Email Notification --> ------------------- \\
                $appointment->user->notify(new AppointmentCreateNotification($newAppointment));
                $appointment->staff->user->notify(new AppointmentCreateNotification($newAppointment));
                $adminUser->notify(new AppointmentCreateNotification($newAppointment));
                event(new PostCreateNoti($newAppointment));

                if ($credentials->client_id && $credentials->client_secret) {
                    // ------------------- <-- Google Calendar Event --> ------------------- \\
                    $calendarEventResponse = $this->createGoogleCalendarEvent($newAppointment);

                    // Handle any redirect response
                    if ($calendarEventResponse instanceof \Illuminate\Http\RedirectResponse) {
                        return $calendarEventResponse;
                    }
                }


                // Prepare email data
                $userEmail = $appointment->email;
                $staffEmail = $appointment->staff->user->email;
                $adminEmail = 'hw13604@gmail.com';


                // Send email
                if ($userEmail) {
                    SendMail::dispatch($userEmail, $appointment, 'user');
                }
                SendMail::dispatch($staffEmail, $appointment, 'staff');
                SendMail::dispatch($adminEmail, $appointment, 'admin');


                // Commit the transaction
                DB::commit();

                $url = route('nextSlot-booked');
                return response()->json(['success' => true, 'message' => 'Slot booked successfully', 'data' => $url]);
            } catch (\Exception $e) {
                // Rollback in case of error
                DB::rollBack();
                return response()->json(['success' => false, 'message' => 'Failed to book slot', 'error' => $e->getMessage()], 500);
            }
        }
        // Begin Transaction
        DB::beginTransaction();

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

        try {
            $appointment = Appointment::with('slot')->findOrFail($request->appointment_id);

            // If not completed, the user can choose the next slot
            $nextSlot = Slot::where('id', $request->slot_id)->firstOrFail();
            // Attach the next slot to the appointment
            AppointmentSlot::create([
                'appointment_id' => $appointment->id,
                'slot_id' => $nextSlot->id,
            ]);
            
            $userSessions = UserSession::where('user_id', $appointment->user_id)->first();
            $veryNewService = Service::findOrFail($request->service_id);
            $veryNewAppointment = Appointment::create([
                'service_id' => $request->service_id,
                'user_id' => $request->user_id,
                'staff_id' => $request->staff_id,
                'slot_id' => $nextSlot->id,
                // 'total_slots' => $veryNewService->slots,
                'total_slots' => $appointment->total_slots,
                'completed_slots' => $appointment->completed_slots + 1,
                'appointment_date' => $request->appointment_date,
                'first_name' => $appointment->first_name,
                'last_name' => $appointment->last_name,
                'email' => $appointment->email,
                'phone' => $appointment->phone,
                'location' => $appointment->location,
                'price' => 0,
                'status' => 'confirmed',
                'note' => $request->note,
            ]);
            
            // $appointment->completed_slots = $appointment->completed_slots + 1;
            // $appointment->appointment_date = $request->appointment_date;
            // $appointment->note = $request->note;

            if($veryNewAppointment->total_slots == 1) {
                $veryNewAppointment->active = '0';
            }else{
                $veryNewAppointment->active = '1';
            }

            if ($veryNewAppointment->completed_slots == $veryNewAppointment->total_slots) {
                if($veryNewAppointment->status != 'rescheduled') {
                    $veryNewAppointment->status = 'confirmed';
                    $veryNewAppointment->active = '0';
                }
            } else {
                if($veryNewAppointment->status != 'rescheduled') {
                    $veryNewAppointment->status = 'confirmed';
                    $veryNewAppointment->active = '1';
                }
            }
            $veryNewAppointment->save();
            
            $appointment->active = '0';
            
            if($appointment->status != 'canceled') {
                if($appointment->status != 'rescheduled') {
                    if($appointment->total_slots > $appointment->completed_slots) {
                        $appointment->status = 'confirmed';
                    }
                }
                if($appointment->total_slots == $appointment->completed_slots) {
                    if($appointment->status != 'rescheduled') {
                        $appointment->status = 'completed';
                    }
                }
            }

            // if($appointment->status != 'canceled'){
            //     $appointment->status = 'confirmed';
            // }

            $appointment->save();

            $sessions = $userSessions->sessions - 1 ?? 0;
            $userSession = UserSession::updateOrCreate(
                ['user_id' => $appointment->user_id],
                [
                    'user_id' => $appointment->user_id,
                    'service_id' => $appointment->service_id,
                    'sessions' => $sessions,
                    'staff_id' => $appointment->staff_id,
                ]
            );

            $UserPackage = UserPackage::where('user_id', $appointment->user_id)
                ->where('service_id', $appointment->service_id)
                ->where('status', 'active')
                ->first();

                if ($UserPackage) {
                    $UserPackage->used_sessions = $UserPackage->used_sessions + 1;
                    $UserPackage->save();
                }

                if($UserPackage && $UserPackage->used_sessions == $UserPackage->sessions) {
                    $UserPackage->status = 'inactive';
                    $UserPackage->save();
                }


            // $newAppointment = Appointment::with('slot', 'staff.user', 'service', 'user')->findOrFail($request->appointment_id);
            $newAppointment = Appointment::with('slot', 'staff.user', 'service', 'user')->findOrFail($veryNewAppointment->id);


            $newAppointment->package_id = $UserPackage->id ?? null;
            $newAppointment->save();

            $adminUser = User::role('admin')->first();

            // ------------------- <-- Email Notification --> ------------------- \\
            $appointment->user->notify(new AppointmentCreateNotification($newAppointment));
            $appointment->staff->user->notify(new AppointmentCreateNotification($newAppointment));
            $adminUser->notify(new AppointmentCreateNotification($newAppointment));
            event(new PostCreateNoti($newAppointment));

            if ($credentials->client_id && $credentials->client_secret) {
                // ------------------- <-- Google Calendar Event --> ------------------- \\
                $calendarEventResponse = $this->createGoogleCalendarEvent($newAppointment);

                // Handle any redirect response
                if ($calendarEventResponse instanceof \Illuminate\Http\RedirectResponse) {
                    return $calendarEventResponse;
                }
            }


            // Prepare email data
            $userEmail = $appointment->email;
            $staffEmail = $appointment->staff->user->email;
            $adminEmail = 'hw13604@gmail.com';


            // Send email
            if ($userEmail) {
                SendMail::dispatch($userEmail, $appointment, 'user');
            }
            SendMail::dispatch($staffEmail, $appointment, 'staff');
            SendMail::dispatch($adminEmail, $appointment, 'admin');


            // Commit the transaction
            DB::commit();

            $url = route('nextSlot-booked');
            return response()->json(['success' => true, 'message' => 'Slot booked successfully', 'data' => $url]);
        } catch (\Exception $e) {
            // Rollback in case of error
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Failed to book slot', 'error' => $e->getMessage()], 500);
        }
    }

    public function stripeSuccess(Request $request)
    {
        $googleCredentials = GoogleCredential::first();
        // if (empty(env('GOOGLE_CLIENT_ID')) || empty(env('GOOGLE_CLIENT_SECRET'))) {
        if (empty($googleCredentials) || empty($googleCredentials->client_id) || empty($googleCredentials->client_secret)) {

            $validated = Session::get('SessionData');


            DB::beginTransaction();

            try {
                // Retrieve the price from the Service model
                $service = Service::findOrFail($validated['service_id']);

                // Discount Work
                $discount = Discount::where('service_id', $validated['service_id'])
                    ->where('status', 1)
                    ->where('start_date', '<=', now())
                    ->where('expired_date', '>=', now())
                    ->first();

                if ($discount) {
                    $discountedPrice = $service->price - ($service->price * ($discount->percentage / 100));
                    $validated['price'] = $discountedPrice;
                }else{
                    $validated['price'] = $service->price;
                }           

                $validated['total_slots'] = $service->slots;
                $validated['completed_slots'] = 1;
                
                if($validated['total_slots'] == 1){
                    $validated['active'] = '0';
                }else{
                    $validated['active'] = '1';
                }
                
                
                if($validated['total_slots'] == $validated['completed_slots']) {
                    $validated['status'] = 'fully_completed';
                }else if($validated['total_slots'] > $validated['completed_slots']) {
                    $validated['status'] = 'confirmed';
                    // $validated['status'] = 'awaiting_next_slot';
                }else{
                    $validated['status'] = 'confirmed';
                }

                // Create the appointment
                $data = Appointment::create($validated);

                if ($data->total_slots == 1) {
                    $userSession = UserSession::updateOrCreate(
                        ['user_id' => $data->user_id],
                        [
                            'user_id' => $data->user_id,
                            'service_id' => $data->service_id,
                            'sessions' => 0,
                            'staff_id' => $data->staff_id,
                        ]
                    );
                } else {
                    $sessions = $data->total_slots - 1;
                    $userSession = UserSession::updateOrCreate(
                        ['user_id' => $data->user_id],
                        [
                            'user_id' => $data->user_id,
                            'service_id' => $data->service_id,
                            'sessions' => $sessions,
                            'staff_id' => $data->staff_id,
                        ]
                    );
                }

                // Ensure that slot_id is set before creating the AppointmentSlot
                if (isset($validated['slot_id'])) {
                    AppointmentSlot::create([
                        'appointment_id' => $data->id,
                        'slot_id' => $validated['slot_id'] // Use the validated slot_id
                    ]);
                }

                // Load the appointment with relationships
                $appointment = Appointment::with('slot', 'staff.user', 'service', 'user')->findOrFail($data->id);

                // Retrieve the Stripe session to get payment details
                $stripeSecretKey = env('STRIPE_SECRET_KEY', 'sk_test_51LkfAQH65lvSBiDK232wi93QAEfeM0XgS8s62kRse0LGoKn2pHxZhMu23pA4w5CyqeR7jaichrCsgnSQdz5S7NPD00GOpROogE');
                $stripe = new StripeClient([
                    'api_key' => $stripeSecretKey,
                ]);
                $sessionId = Session::get('stripe_checkout_id');
                $session = $stripe->checkout->sessions->retrieve($sessionId);

                // Save payment data
                Payment::create([
                    'appointment_id' => $appointment->id,
                    'payment_id' => $session->payment_intent, // Payment Intent ID
                    'amount' => $session->amount_total, // Total amount in cents
                    'currency' => $session->currency, // Currency
                    'status' => $session->payment_status, // Payment status (e.g., 'paid')
                ]);

                $package = UserPackage::create([
                    'user_id' => $appointment->user_id,
                    'service_id' => $appointment->service_id,
                    'sessions' => $appointment->total_slots,
                    'used_sessions' => 1,
                ]);

                if($appointment->total_slots == 1){
                    $package->status = 'inactive';
                }else{
                    $package->status = 'active';
                }

                // Save package
                $package->save();

                $appointment->package_id = $package->id;
                $appointment->save();

                $adminUser = User::role('admin')->first();
                if ($appointment->user != null) {
                    // Send notification
                    $appointment->user->notify(new AppointmentCreateNotification($appointment));
                    $appointment->staff->user->notify(new AppointmentCreateNotification($appointment));
                    $adminUser->notify(new AppointmentCreateNotification($appointment));
                    event(new PostCreateNoti($appointment));
                }

                // Prepare email data
                $userEmail = $validated['email'];
                $staffEmail = $appointment->staff->user->email;
                $adminEmail = 'hw13604@gmail.com';


                // Send email
                if ($userEmail) {
                    SendMail::dispatch($userEmail, $appointment, 'user');
                }
                SendMail::dispatch($staffEmail, $appointment, 'staff');
                SendMail::dispatch($adminEmail, $appointment, 'admin');

                // Commit the transaction
                DB::commit();
                return redirect()->route('payment-success')->with('success', 'Appointment created successfully');

            } catch (\Exception $e) {
                DB::rollBack();
                return redirect()->route('appointment')->with('error', 'Failed to create appointment');
            }
        } else {
            $validated = Session::get('SessionData');

            DB::beginTransaction();
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

            try {
                // Retrieve the price from the Service model
                $service = Service::findOrFail($validated['service_id']);

                // Discount Work
                $discount = Discount::where('status', 1)
                ->where('service_id', $service->id)
                ->where('start_date', '<=', now())
                ->whereDate('expired_date', '>=', now())
                ->first();

                if ($discount) {
                    $validated['price'] = $service->price - ($service->price * ($discount->percentage / 100));
                }else {
                    $validated['price'] = $service->price;
                }

                $validated['total_slots'] = $service->slots;
                $validated['completed_slots'] = 1;

                if($validated['total_slots'] == 1){
                    $validated['active'] = '0';
                }else{
                    $validated['active'] = '1';
                }


                // Create the appointment
                $data = Appointment::create($validated);

                if ($data->total_slots == 1) {
                    $userSession = UserSession::updateOrCreate(
                        ['user_id' => $data->user_id],
                        [
                            'user_id' => $data->user_id,
                            'service_id' => $data->service_id,
                            'sessions' => 0,
                            'staff_id' => $data->staff_id,
                        ]
                    );
                } else {
                    $sessions = $data->total_slots - 1;
                    $userSession = UserSession::updateOrCreate(
                        ['user_id' => $data->user_id],
                        [
                            'user_id' => $data->user_id,
                            'service_id' => $data->service_id,
                            'sessions' => $sessions,
                            'staff_id' => $data->staff_id,
                        ]
                    );
                }

                // Ensure that slot_id is set before creating the AppointmentSlot
                if (isset($validated['slot_id'])) {
                    AppointmentSlot::create([
                        'appointment_id' => $data->id,
                        'slot_id' => $validated['slot_id'] // Use the validated slot_id
                    ]);
                }

                // Load the appointment with relationships
                $appointment = Appointment::with('slot', 'staff.user', 'service', 'user')->findOrFail($data->id);

                // Retrieve the Stripe session to get payment details
                $stripeSecretKey = env('STRIPE_SECRET_KEY', 'sk_test_51LkfAQH65lvSBiDK232wi93QAEfeM0XgS8s62kRse0LGoKn2pHxZhMu23pA4w5CyqeR7jaichrCsgnSQdz5S7NPD00GOpROogE');
                $stripe = new StripeClient([
                    'api_key' => $stripeSecretKey,
                ]);
                $sessionId = Session::get('stripe_checkout_id');
                $session = $stripe->checkout->sessions->retrieve($sessionId);

                // Save payment data
                Payment::create([
                    'appointment_id' => $appointment->id,
                    'payment_id' => $session->payment_intent, // Payment Intent ID
                    'amount' => $session->amount_total, // Total amount in cents
                    'currency' => $session->currency, // Currency
                    'status' => $session->payment_status, // Payment status (e.g., 'paid')
                ]);

                $package = UserPackage::create([
                    'user_id' => $appointment->user_id,
                    'service_id' => $appointment->service_id,
                    'sessions' => $appointment->total_slots,
                    'used_sessions' => 1,
                ]);

                if($appointment->total_slots == 1){
                    $package->status = 'inactive';
                }else{
                    $package->status = 'active';
                }

                // Save package
                $package->save();

                $appointment->package_id = $package->id;
                $appointment->save();

                $adminUser = User::role('admin')->first();
                if ($appointment->user != null) {
                    // Send notification
                    $appointment->user->notify(new AppointmentCreateNotification($appointment));
                    $appointment->staff->user->notify(new AppointmentCreateNotification($appointment));
                    $adminUser->notify(new AppointmentCreateNotification($appointment));
                    event(new PostCreateNoti($appointment));
                }

                // Prepare email data
                $userEmail = $validated['email'];
                $staffEmail = $appointment->staff->user->email;
                $adminEmail = 'hw13604@gmail.com';


                if ($credentials->client_id && $credentials->client_secret) {
                    // Create Google Calendar event
                    $calendarEventResponse = $this->createGoogleCalendarEvent($appointment);

                    // Handle any redirect response
                    if ($calendarEventResponse instanceof \Illuminate\Http\RedirectResponse) {
                        return $calendarEventResponse;
                    }
                }

                // Send email
                if ($userEmail) {
                    SendMail::dispatch($userEmail, $appointment, 'user');
                }
                SendMail::dispatch($staffEmail, $appointment, 'staff');
                SendMail::dispatch($adminEmail, $appointment, 'admin');

                // Commit the transaction
                DB::commit();
                return redirect()->route('payment-success')->with('success', 'Appointment created successfully');

            } catch (\Exception $e) {
                DB::rollBack();
                return redirect()->route('appointment')->with('error', 'Failed to create appointment');
            }
        }
    }

    private function createGoogleCalendarEvent($appointment)
    {
        \Log::info('Creating Google Calendar event for appointment ID: ' . $appointment->id);
        return $this->googleCalendarService->createEvent($appointment);
    }



    // private function createGoogleCalendarEvent($appointment)
    // {
    //     // Get the admin user
    //     $adminUser = User::role('admin')->first();

    //     // Check if the admin has a Google token
    //     if (!$adminUser->google_token) {
    //         Log::error('Admin Google token not found. Please authenticate with Google.');
    //         return redirect('/google-auth')->with('error', 'Admin needs to authenticate with Google.');
    //     }

    //     // Check if the token is expired and try to refresh it
    //     if (now()->greaterThan($adminUser->google_token_expiry)) {
    //         if (!$this->refreshGoogleToken($adminUser)) {
    //             return redirect('/google-auth')->with('error', 'Admin Google token expired. Please authenticate again.');
    //         }
    //     }

    //     // Use the admin's token to create the calendar event
    //     $adminToken = $adminUser->google_token;

    //     // Prepare the event details
    //     $appointmentDate = new \DateTime($appointment->appointment_date);
    //     $event = [
    //         'summary' => 'Appointment with ' . $appointment->first_name . ' ' . $appointment->last_name,
    //         'description' => 'Event Title: ' . $appointment->service->name .
    //             ' by ' . $appointment->staff->user->name .
    //             ' at ' . (new \DateTime($appointment->slot->available_from))->format('h:i A') .
    //             ' to ' . (new \DateTime($appointment->slot->available_to))->format('h:i A'),
    //         'location' => $appointment->location,
    //         'start' => [
    //             'dateTime' => $appointmentDate->format(DATE_ISO8601),
    //             'timeZone' => 'America/Los_Angeles',
    //         ],
    //         'end' => [
    //             'dateTime' => $appointmentDate->modify('+1 hour')->format(DATE_ISO8601),
    //             'timeZone' => 'America/Los_Angeles',
    //         ],
    //         'attendees' => [
    //             ['email' => $appointment->email], // User's email
    //             ['email' => $appointment->staff->user->email], // Staff email, if you want them included as well
    //         ],            
    //         'reminders' => [
    //             'useDefault' => false,
    //             'overrides' => [['method' => 'popup', 'minutes' => 10]],
    //         ],
    //     ];

    //     // Log event details before sending
    //     Log::info('Creating Google Calendar Event for Admin', ['event' => $event]);

    //     // Use Guzzle to send the request for admin
    //     $client = new \GuzzleHttp\Client();
    //     try {
    //         $response = $client->post('https://www.googleapis.com/calendar/v3/calendars/primary/events', [
    //             'headers' => [
    //                 'Authorization' => 'Bearer ' . $adminToken,
    //                 'Content-Type' => 'application/json',
    //             ],
    //             'json' => $event,
    //             'query' => ['sendUpdates' => 'all',],
    //         ]);

    //         // Log response status and body
    //         Log::info('Admin Event Creation Response', ['status' => $response->getStatusCode(), 'body' => $response->getBody()->getContents()]);

    //         if ($response->getStatusCode() == 200) {
    //             Log::info('Google Calendar Event Created Successfully for Admin');
    //         } else {
    //             Log::error('Google Calendar Event Creation Failed for Admin');
    //         }
    //     } catch (\Exception $e) {
    //         Log::error('Google API Error for Admin: ' . $e->getMessage());
    //     }

    //     // // Now create the event for the staff user
    //     // $staffUser = $appointment->staff->user;

    //     // // Check if the staff has a Google token
    //     // if (!$staffUser->google_token) {
    //     //     Log::error('Staff Google token not found for staff ID ' . $staffUser->id . '. Please authenticate with Google.');
    //     //     return; // Optionally, return here or handle differently
    //     // }

    //     // // Check if the token is expired and try to refresh it
    //     // if (now()->greaterThan($staffUser->google_token_expiry)) {
    //     //     if (!$this->refreshGoogleToken($staffUser)) {
    //     //         Log::error('Staff Google token expired for staff ID ' . $staffUser->id . '. Please authenticate again.');
    //     //         return; // Optionally, return here or handle differently
    //     //     }
    //     // }

    //     // // Use the staff user's token to create the calendar event
    //     // $staffToken = $staffUser->google_token;

    //     // // Log event details before sending for staff
    //     // Log::info('Creating Google Calendar Event for Staff ID ' . $staffUser->id, ['event' => $event]);

    //     // // Use Guzzle to send the request for staff
    //     // try {
    //     //     $response = $client->post('https://www.googleapis.com/calendar/v3/calendars/primary/events', [
    //     //         'headers' => [
    //     //             'Authorization' => 'Bearer ' . $staffToken,
    //     //             'Content-Type' => 'application/json',
    //     //         ],
    //     //         'json' => $event,
    //     //     ]);

    //     //     // Log response status and body
    //     //     Log::info('Staff Event Creation Response', ['status' => $response->getStatusCode(), 'body' => $response->getBody()->getContents()]);

    //     //     if ($response->getStatusCode() == 200) {
    //     //         Log::info('Google Calendar Event Created Successfully for Staff ID ' . $staffUser->id);
    //     //     } else {
    //     //         Log::error('Google Calendar Event Creation Failed for Staff ID ' . $staffUser->id);
    //     //     }
    //     // } catch (\Exception $e) {
    //     //     Log::error('Google API Error for Staff ID ' . $staffUser->id . ': ' . $e->getMessage());
    //     // }
    // }


    public function paymentFail()
    {
        return view('guest.paymentFail');
        // return redirect()->route('appointment')->with('error', 'Payment failed');
    }
    public function nextSlotBook()
    {
        return view('guest.nextSlot');
    }

    public function paymentSuccess()
    {
        return view('guest.paymentSuccess');
    }
    public function paymentFailViwe()
    {
        return view('guest.paymentFail');
    }


}
