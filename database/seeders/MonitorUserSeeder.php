<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class MonitorUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Queue Monitor',
            'email' => 'monitor@example.com',
            'password' => Hash::make('monitor123'),
            'role_as' => '2',
            'resident_number' => 'monitor001',
            'email_verified_at' => now(),
        ]);
    }
}