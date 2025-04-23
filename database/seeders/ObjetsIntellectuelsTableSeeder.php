<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use App\Models\ObjetIntellectuel;

class ObjetsIntellectuelsTableSeeder extends Seeder
{
    public function run()
    {


        // 🔐 Désactiver les contraintes
    DB::statement('SET FOREIGN_KEY_CHECKS=0;');

         // Vider la table
    ObjetIntellectuel::truncate();

        // 🔐 Réactiver les contraintes
    DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $faker = Faker::create();

        // TV
        ObjetIntellectuel::create([
            'nom' => $faker->word,
            'identifiant' => $faker->uuid,
            'type' => 'TV',
            'etat' => $faker->randomElement(['on', 'off']),
            'chaine_actuelle' => $faker->word,
            'volume' => $faker->numberBetween(0, 100),
            'mode' => $faker->randomElement(['eco', 'confort']),
            'couleur' => $faker->safeColorName,
            'presence' => $faker->boolean,
            'duree_presence' => $faker->numberBetween(1, 24),
            'derniere_interaction' => $faker->dateTimeThisYear(),
            'consommation_energie' => $faker->randomFloat(2, 10, 150),
        ]);

        // Lampe
        ObjetIntellectuel::create([
            'nom' => $faker->word,
            'identifiant' => $faker->uuid,
            'type' => 'Lampe',
            'etat' => $faker->randomElement(['on', 'off']),
            'luminosite' => $faker->randomFloat(2, 0, 100),
            'couleur' => $faker->safeColorName,
            'presence' => $faker->boolean,
            'duree_presence' => $faker->numberBetween(1, 24),
            'derniere_interaction' => $faker->dateTimeThisYear(),
            'consommation_energie' => $faker->randomFloat(2, 5, 50),
        ]);

        // Thermostat
        ObjetIntellectuel::create([
            'nom' => $faker->word,
            'identifiant' => $faker->uuid,
            'type' => 'Thermostat',
            'temperature_actuelle' => $faker->randomFloat(2, 15, 30),
            'temperature_cible' => $faker->randomFloat(2, 18, 25),
            'mode' => $faker->randomElement(['eco', 'confort', 'off']),
            'etat' => $faker->randomElement(['on', 'off']),
            'presence' => $faker->boolean,
            'derniere_interaction' => $faker->dateTimeThisYear(),
            'consommation_energie' => $faker->randomFloat(2, 20, 100),
        ]);

        // Capteur de présence
        ObjetIntellectuel::create([
            'nom' => $faker->word,
            'identifiant' => $faker->uuid,
            'type' => 'Capteur de présence',
            'etat' => $faker->randomElement(['on', 'off']),
            'presence' => $faker->boolean,
            'duree_presence' => $faker->numberBetween(1, 24),
            'derniere_interaction' => $faker->dateTimeThisYear(),
            'consommation_energie' => $faker->randomFloat(2, 1, 10),
        ]);

        // Store électrique
        ObjetIntellectuel::create([
            'nom' => $faker->word,
            'identifiant' => $faker->uuid,
            'type' => 'Store électrique',
            'etat' => $faker->randomElement(['on', 'off']),
            'position' => $faker->numberBetween(0, 100),
            'derniere_interaction' => $faker->dateTimeThisYear(),
            'consommation_energie' => $faker->randomFloat(2, 10, 60),
        ]);
    }
}