<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Level; 
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            ObjetsIntellectuelsTableSeeder::class,
            InteractionsObjetsTableSeeder::class,
            LevelSeeder::class,
        ]);
        
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'points' => 0,
            'level_id' => Level::where('name', 'Débutant')->first()?->id,
        ]);
    }
}
