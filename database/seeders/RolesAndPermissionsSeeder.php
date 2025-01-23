<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\PermissionRegistrar;
use App\Models\Staff;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
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
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $staffRole = Role::firstOrCreate(['name' => 'staff']);
        $userRole = Role::firstOrCreate(['name' => 'user']);

        // Create Admin User
        $admin = User::firstOrCreate([
            'email' => 'admin@example.com',
        ], [
            'name' => 'Admin User',
            'password' => Hash::make('admin123'),
        ]);

        $admin->assignRole($adminRole);

        // Create Staff User
        $staff = User::firstOrCreate([
            'email' => 'staff@example.com',
        ], [
            'name' => 'Staff User',
            'password' => Hash::make('staff123'),
        ]);

        $staff->assignRole($staffRole);

        Staff::firstOrCreate([
            'user_id' => $staff->id,
            'status' => 'active',
            'notes' => 'Staff Notes',
            'image' => 'image.png',
        ]);
        
        // Create Regular User
        $user = User::firstOrCreate([
            'email' => 'user@example.com',
        ], [
            'name' => 'User User',
            'password' => Hash::make('user123'),
        ]);

        $user->assignRole($userRole);

        // Assign permissions to roles
        $adminRole->givePermissionTo($adminRole);
        $staffRole->givePermissionTo($staffRole);
        $userRole->givePermissionTo($userRole);
    }
}
