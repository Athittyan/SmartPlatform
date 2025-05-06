<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Level;

class LevelSeeder extends Seeder
{
    public function run(): void
    {
        // Vérifie si le niveau "Débutant" existe déjà
        $debutant = Level::firstOrCreate(
            ['name' => 'Débutant'],
            ['cost' => 1] // Définit le coût pour ce niveau s'il est créé
        );

        // Tu peux répéter cette logique pour les autres niveaux si nécessaire
        $intermediaire = Level::firstOrCreate(
            ['name' => 'Intermédiaire'],
            ['cost' => 3]
        );

        $expert = Level::firstOrCreate(
            ['name' => 'Expert'],
            ['cost' => 7]
        );
    }
}

