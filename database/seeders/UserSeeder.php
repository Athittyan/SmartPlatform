<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon;
use App\Models\User;
use App\Models\Level;


class UserSeeder extends Seeder
{
    public function run(): void
    {
        $debutant = Level::firstOrCreate(
            ['name' => 'Débutant'],
            ['cost' => 1] // 
        );
        
        // Admin
        if (!User::where('email', 'admin@example.com')->exists()) {
            User::create([
                'name' => 'Admin One',
                'email' => 'admin@example.com',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
                'email_verified_at' => now(),
                'points' => 10,
                'level_id' => $debutant?->id,
            ]);
        }

        // Simple
        if (!User::where('email', 'simple@example.com')->exists()) {
            User::create([
                'name' => 'Simple One',
                'email' => 'simple@example.com',
                'password' => Hash::make('simple123'),
                'role' => 'simple',
                'email_verified_at' => now(),
                'points' => 0,
                'level_id' => $debutant?->id,
            ]);
        }

        // Complexe
        if (!User::where('email', 'complexe@example.com')->exists()) {
            User::create([
                'name' => 'Complexe One',
                'email' => 'complexe@example.com',
                'password' => Hash::make('complexe123'),
                'role' => 'complexe',
                'email_verified_at' => now(),
                'points' => 0,
                'level_id' => $debutant?->id,
            ]);
        }
    }
}   