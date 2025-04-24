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
                'points' => 10,
                'level_id' => $debutant?->id,
            ]);
        }

        // Visiteur
        if (!User::where('email', 'visiteur@example.com')->exists()) {
            User::create([
                'name' => 'Visiteur One',
                'email' => 'visiteur@example.com',
                'password' => Hash::make('visiteur123'),
                'role' => 'visiteur',
                'points' => 0,
                'level_id' => $debutant?->id,
            ]);
        }
    }
}