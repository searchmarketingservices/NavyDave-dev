<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PostPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'create posts',
            'edit posts',
            'delete posts',
            'view posts',
            'edit comments',
            'delete comments',
        ];
    
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }
    
        // Assign 'delete posts' permission to admin only
        $adminRole = Role::where('name', 'admin')->first();
        $adminRole->givePermissionTo('delete posts');
    
        // Give all users permission to edit/delete their own comments (later restricted by policies)
        $userRole = Role::where('name', 'user')->first();
        $userRole->givePermissionTo(['edit comments', 'delete comments']);
    }
}
