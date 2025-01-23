<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Staff;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Permission;

class StaffController extends Controller
{
    public function index()
    {
        return view('dashboard.admin.staff.index');
    }


    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'phone' => 'required|string|max:20',
                'status' => 'required|string',
                'notes' => 'nullable|string',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:4048',
            ]);
            $user = User::create([
                        'name' => $validated['first_name'] . ' ' . $validated['last_name'],
                        'email' => $validated['email'],
                        'phone' => $validated['phone'],
                        'password' => bcrypt('navydave123'),
                    ]);

                    // Handle image upload
                    if ($request->hasFile('image')) {
                        // $imagePath = $request->file('image')->store('public/staff');
                        // $finalPath = explode('public/', $imagePath)[1];
                        // $validated['image'] = $finalPath;

                        $extension = $request->file('image')->getClientOriginalExtension();
                        $uniqueName = 'staff' . Str::random(40) . '.' . $extension;
                        $request->file('image')->storeAs('public', $uniqueName);
                        $validated['image'] = $uniqueName;
                    }else{
                       // Use the default image
                        $defaultImagePath = 'assets/images/default-user.webp';
                        // Store the default image in the public storage
                        $uniqueName = 'staff/default-user.webp';
                        Storage::disk('public')->copy($defaultImagePath, $uniqueName);
                        $validated['image'] = $uniqueName;
                    }

                    // Create a new staff entry
                    $staff = Staff::create([
                        'user_id' => $user->id,
                        'image' => $validated['image'] ?? null,
                        'status' => $validated['status'],
                        'notes' => $validated['notes'] ?? null,
                    ]);


                    app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

                    // Create permissions
                    $permissions = [
                        'create roles and permissions',
                        'read roles and permissions',
                        'update roles and permissions',
                        'delete roles and permissions',
                    ];

                    foreach ($permissions as $permission) {
                        Permission::firstOrCreate(['name' => $permission]);
                    }
                    // Create roles and assign created permissions
                    $staffRole = Role::firstOrCreate(['name' => 'staff']);
                    // Create Admin User
                    $staff = User::firstOrCreate([
                        'email' => $validated['email'],
                    ], [
                        'name' => $validated['first_name'] . ' ' . $validated['last_name'],
                        'password' => Hash::make('navydave123'),
                    ]);

                    $staff->assignRole($staffRole);
                    $staffRole->givePermissionTo($staffRole);

            return response()->json(['success' => true, 'message' => 'Staff added successfully!']);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['success' => false, 'errors' => $e->errors()]);
        }
    }

    public function show()
    {
        $staff = Staff::orderByDesc('id')->with('user')->paginate(10);
        return response()->json($staff);
    }

    public function edit($id)
    {
        $staff = Staff::find($id);
        return view('dashboard.admin.staff.edit', compact('staff'));
    }

public function update(Request $request, $id)
{
    try {
        $validated = $request->validate([
            'first_name' => 'nullable|string|max:255',
            'email' => 'nullable|email',
            'phone' => 'nullable|string|max:20',
            'status' => 'nullable|string',
            'notes' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:4048',
        ]);

        // Find the staff record by ID
        $staff = Staff::findOrFail($id);
        $user = User::findOrFail($staff->user_id);
        // Update the user information
        $user->update([
            'name' => $validated['first_name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
        ]);

        // Handle image upload if a new image is provided
        if ($request->hasFile('image')) {
            // Delete the old image if it exists
            if ($staff->image) {
                $oldImagePath = storage_path('app/public/' . $staff->image);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }

            // Upload the new image
            // $imagePath = $request->file('image')->store('public/staff');
            // $finalPath = explode('public/', $imagePath)[1];
            // $validated['image'] = $finalPath;

            $extension = $request->file('image')->getClientOriginalExtension();
            $uniqueName = 'staff' . Str::random(40) . '.' . $extension;
            $request->file('image')->storeAs('public', $uniqueName);
            $validated['image'] = $uniqueName;
        }

        // Update the staff entry with new information
        $staff->update([
            'image' => $validated['image'] ?? $staff->image,
            'status' => $validated['status'],
            'notes' => $validated['notes'] ?? $staff->notes,
        ]);

        return redirect()->route('admin.staff')->with('success', 'Staff updated successfully!');
    } catch (\Illuminate\Validation\ValidationException $e) {
        return back()->withErrors($e->errors())->withInput();
    }
}


public function destroy($id)
{
    $staff = Staff::findOrFail($id);

    if ($staff->user_id) {
        $user = User::find($staff->user_id);
        if ($user) {
            $user->delete();
        }
    }

     // Delete the image file if it exists
     if ($staff->image) {
        $imagePath = storage_path('app/public/' . $staff->image);
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }
    }
    $staff->delete();
    return response()->json(['success' => true, 'message' => 'Staff deleted successfully!']);
}


}
