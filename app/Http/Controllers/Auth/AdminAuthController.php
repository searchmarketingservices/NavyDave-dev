<?php

namespace App\Http\Controllers\Auth;

use App\Models\Appointment;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\Subscriber;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

use Laravel\Socialite\Facades\Socialite;
use Spatie\GoogleCalendar\Event;
use App\Models\Slot;
use Carbon\Carbon;
use GuzzleHttp\Client;
use App\Jobs\SendWelcomeMail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Password;
use App\Notifications\ResetPasswordNotification;
use App\Jobs\SendPasswordResetEmail;
use App\Models\Staff;
use App\Models\AppointmentChange;

class AdminAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('dashboard.admin.auth.login');
    }
    public function showLinkRequestForm()
    {
        return view('dashboard.admin.auth.resetPassword');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:users,email']);

        $user = User::where('email', $request->email)->first();
        $token = Password::createToken($user);

        // $user->notify(new ResetPasswordNotification($token));
        $resetUrl = url(route('password.reset', ['token' => $token, 'email' => $user->email], false));
        SendPasswordResetEmail::dispatch($user->email, $resetUrl);

        return back()->with('success', 'Password reset link sent!');
    }

    public function showResetForm(Request $request, $token = null)
    {
        return view('dashboard.admin.auth.reset-password-form')->with(['token' => $token, 'email' => $request->email]);
    }

    public function reset(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email|exists:users,email',
            'password' => 'required|confirmed|min:8',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user) use ($request) {
                $user->password = bcrypt($request->password);
                $user->save();
            }
        );

        if ($status == Password::PASSWORD_RESET) {
            return redirect()->route('login')->with('success', 'Password reset successfully!');
        }

        return back()->withErrors(['email' => [__($status)]]);
    }



    public function login(Request $request)
    {
        // Validate the request
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        // Attempt to log the user in
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            // Check if the user has the 'admin' role
            if (Auth::user()->hasRole('admin')) {
                return redirect()->route('admin.dashboard'); // Redirect to admin dashboard
            } else if (Auth::user()->hasRole('staff')) {
                $staff = Staff::where('user_id', auth()->user()->id)->get();
                if(count($staff) > 0){
                    return redirect()->route('staff.dashboard');
                }else{
                    Auth::logout(); // Log out if not an admin
                    return redirect()->route('login')->withErrors('Unauthorized access.');
                }
            } else if (Auth::user()->hasRole('user')) {
                return redirect()->route('user.dashboard');
            } else {
                Auth::logout(); // Log out if not an admin
                return redirect()->route('admin.login')->withErrors('Unauthorized access.');
            }
        }

        // Log the failed attempt for debugging
        Log::info('Login attempt failed for email: ' . $request->email);

        // If authentication fails, redirect back with an error message
        return back()->withErrors(['email' => 'Invalid credentials.']);
    }

    public function showRegisterForm()
    {
        return view('dashboard.admin.auth.register');
    }

    public function register(Request $request)
    {
        // Validate the form data
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'zipcode' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Create new user
        $user = User::create([
            'name' => $request->name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'city' => $request->city,
            'address' => $request->address,
            'state' => $request->state,
            'zipcode' => $request->zipcode,
        ]);


        // Create the 'admin' role
        $userRole = Role::firstOrCreate(['name' => 'user']);
        // Assign the 'admin' role to the new user
        $user->assignRole($userRole);
        SendWelcomeMail::dispatch($user->email, $user);

        return redirect()->route('login')->with('success', 'Your account has been created successfully!');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }

    public function dashboard()
    {
        $revenue = Payment::sum('amount') / 100;
        $approvedAppointments = Appointment::where('status', 'confirmed')->count();
        $totalAppointments = Appointment::count();
        $pendingAppointments = Appointment::where('status', 'pending')->count();
        $appointments = Appointment::with('slot', 'payment')->orderBy('id', 'desc')->take(10)->get();
        return view('dashboard.admin.dashboard', compact('revenue', 'approvedAppointments', 'totalAppointments', 'pendingAppointments', 'appointments'));
    }

    public function profile()
    {
        $user = auth()->user();
        return view('dashboard.admin.auth.profile', compact('user'));

    }
    public function appointment()
    {
        return view('dashboard.admin.appointment.index');
    }
    public function printAppointmentChanges()
    {
        $changes = AppointmentChange::with(['appointment', 'changedBy', 'oldSlot', 'newSlot'])->orderBy('id', 'desc')->get();
        return view('dashboard.admin.appointment.appointment_changes', compact('changes'));
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
            $uniqueName = 'AdminProfile' . Str::random(40) . '.' . $extension;
            $request->file('image')->storeAs('public', $uniqueName);

            // Update the user's image in the database
            $user->image = $uniqueName;
            $user->save();
        }

        // Redirect back with a success message
        return redirect()->route('admin.profile')->with('success', 'Profile updated successfully.');
    }

    public function subscribers()
    {
        $subscribers = Subscriber::all();
        return view('dashboard.admin.subscribers.index', compact('subscribers'));
    }

    // public function redirectToGoogle()
    // {
    //     return Socialite::driver('google')
    //         ->scopes(['https://www.googleapis.com/auth/calendar'])
    //         ->redirect();
    // }
    public function redirectToGoogle()
    {
        $clientId = DB::table('google_settings')->where('key', 'google_client_id')->value('value');

        return Socialite::driver('google')
            ->scopes(['https://www.googleapis.com/auth/calendar'])
            ->with(['client_id' => $clientId]) // Use the client ID from the database
            ->redirect();
    }
    public function staffRedirectToGoogle()
    {
        // Ensure the user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'You must be logged in to access this page.');
        }

        // Fetch client ID and secret from the database
        $googleCredentials = DB::table('staff_google_credentials')->where('staff_id', Auth::id())->first();

        if ($googleCredentials) {
            config(['services.google.client_id' => $googleCredentials->google_client_id]);
            config(['services.google.client_secret' => $googleCredentials->google_client_secret]);

            // Debugging: Log client credentials
            \Log::info('Redirecting to Google with Client ID: ' . $googleCredentials->google_client_id);

            return Socialite::driver('google')->redirect();
        }

        return redirect()->back()->with('error', 'Google credentials not found.');
    }





    // public function handleGoogleCallback(Request $request)
    // {

    //     // Retrieve Google client credentials from the database
    //     $clientId = DB::table('google_settings')->where('key', 'google_client_id')->value('value');
    //     $clientSecret = DB::table('google_settings')->where('key', 'google_client_secret')->value('value');

    //     // Set the client ID and secret for the Google driver
    //     $googleUser = Socialite::driver('google')
    //         ->stateless()
    //         ->with(['client_id' => $clientId, 'client_secret' => $clientSecret]) // Pass credentials
    //         ->user();

    //     // Get the authenticated user
    //     $user = auth()->user();

    //     // Only allow the admin to save the Google tokens
    //     if ($user->hasRole('admin')) {
    //         $user->google_token = $googleUser->token;
    //         $user->google_refresh_token = $googleUser->refreshToken;
    //         $user->google_token_expiry = now()->addSeconds($googleUser->expiresIn);
    //         $user->save();

    //         Log::info('Admin Google OAuth token saved.');
    //     } else {
    //         Log::error('Non-admin user tried to get Google token.');
    //         return redirect('/')->with('error', 'Only admin can authenticate with Google.');
    //     }

    //     // return redirect('/')->with('success', 'Google OAuth successful.');
    //     return redirect('/admin/google-credentials')->with('success', 'Google Credentials saved.');
    // }

    public function handleGoogleCallback(Request $request)
    {
        // Get the authenticated user
        $user = auth()->user();

        // Determine if the user is admin or staff and fetch the appropriate Google credentials
        if ($user->hasRole('admin')) {
            // Admin: Fetch credentials from the admin settings table
            $clientId = DB::table('google_settings')->where('key', 'google_client_id')->value('value');
            $clientSecret = DB::table('google_settings')->where('key', 'google_client_secret')->value('value');
        } elseif ($user->hasRole('staff')) {
            // Staff: Fetch credentials from the staff settings table
            $googleCredentials = DB::table('staff_google_credentials')->where('staff_id', $user->id)->first();

            if (!$googleCredentials) {
                Log::error('Staff user has no Google credentials.');
                return redirect('/')->with('error', 'No Google credentials found for staff.');
            }

            $clientId = $googleCredentials->google_client_id;
            $clientSecret = $googleCredentials->google_client_secret;
        } else {
            Log::error('User has no valid role.');
            return redirect('/')->with('error', 'Unauthorized user.');
        }

        // Set the client ID and secret for the Google driver
        try {
            $googleUser = Socialite::driver('google')
                ->stateless()
                ->with(['client_id' => $clientId, 'client_secret' => $clientSecret]) // Pass credentials
                ->user();

            // Save Google tokens for both admin and staff in the users table
            $user->google_token = $googleUser->token;
            $user->google_refresh_token = $googleUser->refreshToken;
            $user->google_token_expiry = now()->addSeconds($googleUser->expiresIn);
            $user->save();

            if ($user->hasRole('admin')) {
                Log::info('Admin Google OAuth token saved for user ID: ' . $user->id);
                return redirect('/admin/google-credentials')->with('success', 'Google Credentials saved.');
            } elseif ($user->hasRole('staff')) {
                // Log::info('Staff Google OAuth token saved for staff ID: ' . $user->id);
                Log::info('Staff Google OAuth token saved for staff ID: ' . $user->id);
                return redirect('/staff/google-credentials')->with('success', 'Google Credentials saved.');
            }


        } catch (\Exception $e) {
            Log::error('Google OAuth error: ' . $e->getMessage());
            return redirect('/')->with('error', 'Failed to authenticate with Google.');
        }
    }



    public function syncCalendar()
    {
        // Access token should be stored in session
        $token = session('google_token');

        // Use token to create a new calendar event
        // Fetch events and use them to sync
        $event = new Event;
        $event->name = 'Sample Event';
        $event->startDateTime = now();
        $event->endDateTime = now()->addHour();
        $event->save();

        return "Events synced to Google Calendar!";
    }

    public function check()
    {
        // Get the access token from session
        $token = session('google_token');

        if (!$token) {
            return redirect('/')->with('error', 'Google token not found. Please authenticate with Google.');
        }

        // Prepare the event details
        $event = [
            'summary' => 'New Appointment',
            'start' => [
                'dateTime' => '2024-09-30T10:00:00-07:00', // Set the start date and time
                'timeZone' => 'America/Los_Angeles',
            ],
            'end' => [
                'dateTime' => '2024-09-30T11:00:00-07:00', // Set the end date and time
                'timeZone' => 'America/Los_Angeles',
            ],
        ];

        // Use Guzzle to send the request
        $client = new Client();
        $response = $client->post('https://www.googleapis.com/calendar/v3/calendars/primary/events', [
            'headers' => [
                'Authorization' => 'Bearer ' . $token,
                'Content-Type' => 'application/json',
            ],
            'json' => $event,
        ]);

        if ($response->getStatusCode() == 200) {
            Log::error('Google Calendar Event Creation Failed: ', ['response' => $response->getBody()->getContents()]);
            dd("Event created successfully.");
        } else {
            Log::error('Google Calendar Event Creation Failed: ', ['response' => $response->getBody()->getContents()]);
            dd("Event creation failed.");
        }// Check if the token is expired
        if (time() > session('google_token_expiry')) {
            // Redirect for re-authentication if the token is expired
            return redirect('/google-auth')->with('error', 'Your session has expired. Please log in again.');
        }
    }


}

