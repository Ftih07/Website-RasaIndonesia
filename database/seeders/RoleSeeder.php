<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Insert default roles
        Role::insert([
            ['name' => 'customer', 'description' => 'Default role for users', 'created_at' => now()],
            ['name' => 'seller', 'description' => 'Can manage store', 'created_at' => now()],
            ['name' => 'courier', 'description' => 'Handles deliveries', 'created_at' => now()],
            ['name' => 'admin', 'description' => 'Has admin access', 'created_at' => now()],
            ['name' => 'superadmin', 'description' => 'Full access to system', 'created_at' => now()],
            ['name' => 'hybrid', 'description' => 'Seller + Courier', 'created_at' => now()],
        ]);

        // Assign superadmin role to user ID 2 (if exists)
        $superadminRole = Role::where('name', 'superadmin')->first();

        $user = \App\Models\User::find(2); // ambil user ID 2
        if ($user && $superadminRole) {
            $user->roles()->syncWithoutDetaching([$superadminRole->id]);
        }
    }
}
