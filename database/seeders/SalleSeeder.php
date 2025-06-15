<?php

namespace Database\Seeders;

use App\Models\Salle;
use Illuminate\Database\Seeder;

class SalleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $salles = [
            ['nom' => 'Salle 01', 'description' => 'Salle de cours standard'],
            ['nom' => 'Salle 02', 'description' => 'Salle de cours standard'],
            ['nom' => 'Salle 03', 'description' => 'Salle de cours standard'],
            ['nom' => 'Salle 04', 'description' => 'Salle de cours standard'],
            ['nom' => 'Salle 05', 'description' => 'Salle de cours standard'],
            ['nom' => 'Salle 06', 'description' => 'Salle de cours standard'],
            ['nom' => 'Salle 07', 'description' => 'Salle de cours standard'],
            ['nom' => 'Salle 08', 'description' => 'Salle de cours standard'],
            ['nom' => 'Salle 09', 'description' => 'Salle de cours standard'],
            ['nom' => 'Salle 10', 'description' => 'Salle de cours standard'],
            ['nom' => 'Salle de réunion', 'description' => 'Salle dédiée aux réunions'],
            ['nom' => 'Salle de spectacle', 'description' => 'Salle équipée pour les spectacles et présentations'],
            ['nom' => 'Médiathèque', 'description' => 'Espace de lecture et de recherche'],
            ['nom' => 'Hall', 'description' => 'Espace d\'accueil et de détente']
        ];

        foreach ($salles as $salle) {
            Salle::firstOrCreate(
                ['nom' => $salle['nom']],
                $salle
            );
        }
    }
}
