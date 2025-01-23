<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Jobs\SendWelcomeMail;
use App\Jobs\SendWelcomeMail2;
use App\Models\Service;
use App\Models\ServiceAssign;
use App\Models\UserSession;
use App\Models\Staff;
use App\Models\UserPackage;
use App\Models\Appointment;
use Illuminate\Support\Facades\Validator;

class UsersController extends Controller
{

    public function users()
    {
        $users = User::role('user')->get();
        return view('dashboard.admin.users.index', compact('users'));
    }
    public function getUsers()
    {
        // Retrieve Only Active Users (Default Behavior)
        $users = User::with('sessions.service')->role('user')->orderBy('id', 'desc')->get();

        // // Retrieve All Users (Including Soft-Deleted)
        // $users = User::with('sessions.service')->withTrashed()->role('user')->get();

        // // Retrieve Only Soft-Deleted Users
        // $users = User::with('sessions.service')->onlyTrashed()->role('user')->get();
        return response()->json([
            'users' => $users
        ]);
    }

    public function store(Request $request)
    {
        // Validate the form data
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'nullable|string',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'zipcode' => 'nullable|string|max:10',
            'address' => 'nullable|string|max:255',
        ]);

        // Image handling
        $uniqueName = null;
        if ($request->hasFile('image')) {
            $extension = $request->file('image')->getClientOriginalExtension();
            $uniqueName = 'UserProfile' . Str::random(40) . '.' . $extension;
            $request->file('image')->storeAs('public', $uniqueName);
        }

        // Create the user
        $user = User::create([
            'name' => $request->first_name ?? null,
            'last_name' => $request->last_name ?? null,
            'email' => $request->email,
            'password' => bcrypt("user123"),
            'phone' => $request->phone,
            'city' => $request->city,
            'state' => $request->state,
            'zipcode' => $request->zipcode,
            'address' => $request->address,
            'image' => $uniqueName ?? null
        ]);

        // Assign the role
        $user->assignRole('user');

        // Dispatch the job with minimal data (email and user ID)
        SendWelcomeMail2::dispatch($user->email, $user->id);

        return response()->json(['message' => 'User created successfully!', 'user' => $user], 201);
    }


    public function edit(User $user)
    {
        return response()->json($user);
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'zipcode' => 'nullable|string|max:10',
            'address' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $user->name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->city = $request->city;
        $user->state = $request->state;
        $user->zipcode = $request->zipcode;
        $user->address = $request->address;

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

        $user->save();

        return response()->json(['success' => 'User updated successfully', 'user' => $user], 200);
    }

    public function destroy($id)
    {
        // Find the user by id
        $user = User::find($id);

        // Check if the user exists
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        // Check if the user has an image, and delete it if it exists
        // if ($user->image) {
        //     $imagePath = storage_path('app/public/' . $user->image);

        //     // Delete the image from the storage if it exists
        //     if (file_exists($imagePath)) {
        //         unlink($imagePath);
        //     }
        // }

        // Delete the user from the database
        $user->delete();

        return response()->json(['message' => 'User deleted successfully!'], 200);
    }

    public function usersSession()
    {
        $users = User::role('user')->get();
        $packages = Service::get();
        return view('dashboard.admin.user-session.index', compact('users', 'packages'));
    }
    public function sessionAssign($id)
    {
        $user = User::where('id', $id)->first();
        $serviceAssign = ServiceAssign::pluck('service_id');
        $services = Service::whereIn('id', $serviceAssign)->get();

        $staff = Staff::with('user')->where('status', 'Active')->get();
        return view('dashboard.admin.user-session.edit', compact('user', 'services', 'staff'));
    }
    public function sessionAssignSet(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'sessions' => 'required|integer',
            'service' => 'required|integer|min:1',
            'staff' => 'required|',
        ]);

        // Find the user by ID
        $user = User::findOrFail($id);

        $ExistingUserSession = UserSession::where('user_id', $user->id)->first(); // Get the existing userSession
        if ($ExistingUserSession) {
            $ExistingUserSession->sessions += $request->sessions;
            $ExistingUserSession->save();
        } else {
            $userSession = UserSession::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'user_id' => $user->id,
                    'service_id' => $request->service,
                    'sessions' => $request->sessions,
                    'staff_id' => $request->staff,
                ]
            );
        }

        $package = UserPackage::create([
            'user_id' => $user->id,
            'service_id' => $request->service,
            'sessions' => $request->sessions,
            'used_sessions' => 0,
            'status' => 'active',
            'is_free' => 1,
        ]);

        return redirect()->to('admin/user/sessions')->with('success', 'Sessions assigned successfully!');
    }

    public function sessionUpdate(Request $request)
    {
        $userSession = UserSession::where('user_id', $request->id)->first();

        // Validate the request
        $validator = Validator::make($request->all(), [
            'session' => 'required|integer|min:0',
            'service' => function ($attribute, $value, $fail) use ($request, $userSession) {
                // Check if the packageDiv (service dropdown) is displayed
                if ($userSession && $userSession->sessions == 0 && !$value) {
                    $fail('The service field is required.');
                }
            },
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
            ], 400);
        }


        $service = Service::where('is_admin', 1)->first();

        if ($service) {


            // Current sessions before update
            $oldSessions = $userSession->sessions;

            // Calculate the difference
            $sessionDifference = $request->session - $oldSessions;

            // Check if the difference is negative
            if ($sessionDifference < 0) {

                $negativeDifference = abs($sessionDifference);

                // Fetch admin-provided active packages for this user
                $adminPackages = UserPackage::where('user_id', $request->id)
                    ->where('is_free', 1)
                    // ->where('service_id', $service->id)
                    ->where('status', 'active')
                    ->get();

                $totalAvailableSessions = $adminPackages->sum('sessions') - $adminPackages->sum('used_sessions');

                // Check if the reduction is possible
                if ($negativeDifference > $totalAvailableSessions) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Session reduction exceeds available admin-provided sessions.',
                    ], 400);
                }

                // Deduct sessions from admin-provided packages
                foreach ($adminPackages as $package) {
                    $availableSessions = $package->sessions - $package->used_sessions;

                    if ($negativeDifference <= 0) {
                        break;
                    }

                    if ($availableSessions > 0) {
                        $deducted = min($negativeDifference, $availableSessions);
                        $package->sessions -= $deducted;
                        $package->save();

                        $negativeDifference -= $deducted;

                        // Update appointments linked to this package
                        $appointments = Appointment::where('package_id', $package->id)
                            // ->where('status', '!=', 'completed')
                            ->get();

                        foreach ($appointments as $appointment) {
                            // $appointment->total_slots = $appointment->total_slots-$deducted;
                            $appointment->total_slots -= $deducted;
                            $appointment->save();
                        }
                    }

                    if ($package->sessions == $package->used_sessions) {
                        $package->status = "inactive";
                        $package->save();
                    }
                    // If the package's sessions reach 0, delete the package
                    if ($package->sessions == 0) {
                        $package->delete();
                    }
                }
            }

            // Update sessions
            $userSession->sessions = $request->session;
            $userSession->save();

            // Create package for positive difference
            if ($sessionDifference > 0) {
                $user_package = new UserPackage();
                $user_package->user_id = $request->id;
                $user_package->service_id = $request->service ?? $service->id;
                $user_package->sessions = $sessionDifference;
                $user_package->used_sessions = 0;
                $user_package->status = 'active';
                $user_package->is_free = 1;
                $user_package->save();
            }

            return response()->json([
                'success' => true,
                'message' => 'Session Updated Successfully!',
                'userSession' => $userSession,
            ]);
        }
        return response()->json([
            'success' => false,
            'message' => 'Something went wrong. Please try again later',
            'userSession' => $userSession,
        ]);

    }


    public function restore()
    {
        $users = User::with('sessions.service')->onlyTrashed()->role('user')->get();
        return view('dashboard.admin.users.restore', compact('users'));
    }

    public function restoreUser($id)
    {
        $user = User::onlyTrashed()->find($id);

        if (!$user) {
            return response()->json(['message' => 'User not found or already active'], 404);
        }

        $user->restore();

        return response()->json(['message' => 'User restored successfully!'], 200);
    }
    public function permanentlyDelete($id)
    {
        // Find the user in the soft-deleted records
        $user = User::onlyTrashed()->find($id);

        if (!$user) {
            return response()->json(['message' => 'User not found or already active'], 404);
        }

        // Update confirmed appointments
        Appointment::where('user_id', $user->id)
            ->where('status', 'confirmed')
            ->update([
                'status' => 'canceled',
                'active' => 0,
            ]);

        // Delete all packages associated with the user
        UserPackage::where('user_id', $user->id)->delete();

        // Permanently delete the user
        $user->forceDelete();

        return response()->json(['message' => 'User permanently deleted successfully!'], 200);
    }



}
