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
                $action = match ($objet->type) {
                    'TV' => $faker->randomElement(['volume changé', 'TV allumée', 'chaîne modifiée']),
                    'Lampe' => $faker->randomElement(['luminosité modifiée', 'couleur modifiée', 'on/off']),
                    'Thermostat' => 'température réglée',
                    'Store électrique' => 'position modifiée',
                    default => 'état modifié',
                };

                $valeursAvant = [];
                $valeursApres = [];
                $energie = $faker->randomFloat(2, 10, 150);

                switch ($objet->type) {
                    case 'TV':
                        $valeursAvant = [
                            'etat' => 'off',
                            'volume' => $faker->numberBetween(10, 40),
                            'chaine_actuelle' => $faker->numberBetween(1, 10)
                        ];
                        $valeursApres = [
                            'etat' => 'on',
                            'volume' => $faker->numberBetween(60, 100),
                            'chaine_actuelle' => $faker->numberBetween(11, 20),
                            'consommation_energie' => $energie
                        ];
                        break;

                    case 'Lampe':
                        $valeursAvant = [
                            'etat' => 'off',
                            'luminosite' => $faker->numberBetween(10, 50),
                            'couleur' => $faker->safeColorName()
                        ];
                        $valeursApres = [
                            'etat' => 'on',
                            'luminosite' => $faker->numberBetween(60, 100),
                            'couleur' => $faker->safeColorName(),
                            'consommation_energie' => $energie
                        ];
                        break;

                    case 'Thermostat':
                        $valeursAvant = [
                            'etat' => 'off',
                            'temperature_cible' => $faker->numberBetween(18, 21)
                        ];
                        $valeursApres = [
                            'etat' => 'on',
                            'temperature_cible' => $faker->numberBetween(22, 28)
                        ];
                        break;

                    case 'Store électrique':
                        $valeursAvant = [
                            'position' => $faker->numberBetween(0, 50)
                        ];
                        $valeursApres = [
                            'position' => $faker->numberBetween(51, 100)
                        ];
                        break;
                }

                InteractionObjet::create([
                    'objet_intellectuel_id' => $objet->id,
                    'user_id' => 1,
                    'action' => $action,
                    'valeurs_avant' => json_encode($valeursAvant),
                    'valeurs_apres' => json_encode($valeursApres),
                    'consommation_energie' => $energie,
                    'created_at' => $faker->dateTimeBetween('-2 weeks', 'now'),
                    'updated_at' => now()
                ]);
            }
        }
    }
}
