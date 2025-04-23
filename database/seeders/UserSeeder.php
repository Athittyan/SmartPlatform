<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin One',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
                'email_verified_at' => Carbon::now(),
            ]
        );

        // Visiteur
        User::firstOrCreate(
            ['email' => 'visiteur@example.com'],
            [
                'name' => 'Visiteur One',
                'password' => Hash::make('visiteur123'),
                'role' => 'visiteur',
                'email_verified_at' => Carbon::now(),
            ]
        );
    }
}
