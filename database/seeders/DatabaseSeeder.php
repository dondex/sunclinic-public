<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
      

        // Create an admin user
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@test.com', // Set the email to admin@test.com
            'password' => Hash::make('password'), // Use the password "password"
            'resident_number' => '123456789', // Example resident number
            'role_as' => 1, // Set role_as to 1 for admin
        ]);
    }
}