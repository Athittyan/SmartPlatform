<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Models\InteractionObjet;
use App\Models\ObjetIntellectuel;

class InteractionsObjetsTableSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();
        $objets = ObjetIntellectuel::all();

        foreach ($objets as $objet) {
            for ($i = 0; $i < 5; $i++) {
                $avantVolume = $faker->numberBetween(10, 50);
                $apresVolume = $faker->numberBetween(51, 100);
                $energie = $faker->randomFloat(2, 10, 150);

                InteractionObjet::create([
                    'objet_intellectuel_id' => $objet->id,
                    'user_id' => 1, // Tu peux mettre un id dynamique si tu veux
                    'action' => $faker->randomElement(['volume changé', 'TV allumée', 'chaîne modifiée']),
                    'valeurs_avant' => json_encode(['volume' => $avantVolume]),
                    'valeurs_apres' => json_encode([
                        'volume' => $apresVolume,
                        'consommation_energie' => $energie
                    ]),
                    'consommation_energie' => $energie,
                    'created_at' => $faker->dateTimeBetween('-2 weeks', 'now'),
                    'updated_at' => now()
                ]);
            }
        }
    }
}
