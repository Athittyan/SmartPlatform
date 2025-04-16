<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::create([
            'name' => 'Admin One',
            'email' => 'admin@example.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin'
        ]);

        // Visiteur
        User::create([
            'name' => 'Visiteur One',
            'email' => 'visiteur@example.com',
            'password' => Hash::make('visiteur123'),
            'role' => 'visiteur'
        ]);
    }
}
