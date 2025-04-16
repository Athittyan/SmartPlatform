<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Models\ObjetIntellectuel;

class ObjetsIntellectuelsTableSeeder extends Seeder
{
    public function run()
    {
        ObjetIntellectuel::truncate();
        // Créer une instance de Faker pour générer des données aléatoires
        $faker = Faker::create();

        // Créer un objet de chaque type avec des données aléatoires
        ObjetIntellectuel::create([
            'nom' => $faker->word, // Nom de l'objet aléatoire
            'identifiant' => $faker->uuid, // UUID unique pour chaque objet
            'type' => 'TV', // Type : TV
            'temperature_actuelle' => null, // Pas de température pour une TV
            'temperature_cible' => null, // Pas de température pour une TV
            'mode' => $faker->randomElement(['eco', 'comfort', 'off']), // Mode aléatoire
            'etat' => $faker->randomElement(['on', 'off']), // État aléatoire (on ou off)
            'luminosite' => null, // Pas de luminosité pour une TV
            'couleur' => $faker->safeColorName, // Couleur aléatoire
            'chaine_actuelle' => $faker->word, // Chaîne aléatoire pour la TV
            'volume' => $faker->numberBetween(0, 100), // Volume aléatoire entre 0 et 100
            'presence' => $faker->boolean, // Présence aléatoire (true/false)
            'duree_presence' => $faker->numberBetween(1, 24), // Durée de présence entre 1 et 24 heures
            'position' => null, // Pas de position pour une TV
            'derniere_interaction' => $faker->dateTimeThisYear(), // Dernière interaction aléatoire
        ]);

        ObjetIntellectuel::create([
            'nom' => $faker->word, // Nom de l'objet aléatoire
            'identifiant' => $faker->uuid, // UUID unique pour chaque objet
            'type' => 'Lampe', // Type : Lampe
            'temperature_actuelle' => null, // Pas de température pour une lampe
            'temperature_cible' => null, // Pas de température pour une lampe
            'mode' => $faker->randomElement(['eco', 'comfort', 'off']), // Mode aléatoire
            'etat' => $faker->randomElement(['on', 'off']), // État aléatoire (on ou off)
            'luminosite' => $faker->randomFloat(2, 0, 100), // Luminosité aléatoire entre 0 et 100
            'couleur' => $faker->safeColorName, // Couleur aléatoire
            'chaine_actuelle' => null, // Pas de chaîne pour une lampe
            'volume' => null, // Pas de volume pour une lampe
            'presence' => $faker->boolean, // Présence aléatoire (true/false)
            'duree_presence' => $faker->numberBetween(1, 24), // Durée de présence entre 1 et 24 heures
            'position' => null, // Pas de position pour une lampe
            'derniere_interaction' => $faker->dateTimeThisYear(), // Dernière interaction aléatoire
        ]);

        ObjetIntellectuel::create([
            'nom' => $faker->word, // Nom de l'objet aléatoire
            'identifiant' => $faker->uuid, // UUID unique pour chaque objet
            'type' => 'Thermostat', // Type : Thermostat
            'temperature_actuelle' => $faker->randomFloat(2, 15, 30), // Température aléatoire entre 15°C et 30°C
            'temperature_cible' => $faker->randomFloat(2, 18, 25), // Température cible entre 18°C et 25°C
            'mode' => $faker->randomElement(['eco', 'comfort', 'off']), // Mode aléatoire
            'etat' => $faker->randomElement(['on', 'off']), // État aléatoire (on ou off)
            'luminosite' => null, // Pas de luminosité pour un thermostat
            'couleur' => null, // Pas de couleur pour un thermostat
            'chaine_actuelle' => null, // Pas de chaîne pour un thermostat
            'volume' => null, // Pas de volume pour un thermostat
            'presence' => $faker->boolean, // Présence aléatoire (true/false)
            'duree_presence' => null, // Pas de durée de présence pour un thermostat
            'position' => null, // Pas de position pour un thermostat
            'derniere_interaction' => $faker->dateTimeThisYear(), // Dernière interaction aléatoire
        ]);

        ObjetIntellectuel::create([
            'nom' => $faker->word, // Nom de l'objet aléatoire
            'identifiant' => $faker->uuid, // UUID unique pour chaque objet
            'type' => 'Capteur de présence', // Type : Capteur de présence
            'temperature_actuelle' => null, // Pas de température pour un capteur
            'temperature_cible' => null, // Pas de température pour un capteur
            'mode' => null, // Pas de mode pour un capteur
            'etat' => $faker->randomElement(['on', 'off']), // État aléatoire (on ou off)
            'luminosite' => null, // Pas de luminosité pour un capteur
            'couleur' => null, // Pas de couleur pour un capteur
            'chaine_actuelle' => null, // Pas de chaîne pour un capteur
            'volume' => null, // Pas de volume pour un capteur
            'presence' => $faker->boolean, // Présence aléatoire (true/false)
            'duree_presence' => $faker->numberBetween(1, 24), // Durée de présence entre 1 et 24 heures
            'position' => null, // Pas de position pour un capteur
            'derniere_interaction' => $faker->dateTimeThisYear(), // Dernière interaction aléatoire
        ]);

        ObjetIntellectuel::create([
            'nom' => $faker->word, // Nom de l'objet aléatoire
            'identifiant' => $faker->uuid, // UUID unique pour chaque objet
            'type' => 'Store électrique', // Type : Store électrique
            'temperature_actuelle' => null, // Pas de température pour un store
            'temperature_cible' => null, // Pas de température pour un store
            'mode' => null, // Pas de mode pour un store
            'etat' => $faker->randomElement(['on', 'off']), // État aléatoire (on ou off)
            'luminosite' => null, // Pas de luminosité pour un store
            'couleur' => null, // Pas de couleur pour un store
            'chaine_actuelle' => null, // Pas de chaîne pour un store
            'volume' => null, // Pas de volume pour un store
            'presence' => null, // Pas de présence pour un store
            'duree_presence' => null, // Pas de durée de présence pour un store
            'position' => $faker->numberBetween(1, 100), // Position aléatoire pour un store (entre 1 et 100)
            'derniere_interaction' => $faker->dateTimeThisYear(), // Dernière interaction aléatoire
        ]);
    }
}
