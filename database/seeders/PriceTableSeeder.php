<?php

namespace Database\Seeders;

use App\Models\Price;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PriceTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $Tarifs = [
            ["nom"=>'DELF & DALF', "montant"=> 35000, 'level_id' => 31],
            ["nom"=>'DELF & DALF', "montant"=> 42000, 'level_id' => 32],
            ["nom"=>'DELF & DALF', "montant"=> 67000, 'level_id' => 33],
            ["nom"=>'DELF & DALF', "montant"=> 140000, 'level_id' => 36],
        ];

        $Sessions = [
            ["nom"=> "Cours du soir Session 1", "dateDebut"=> '2024-01-18 00:00:00', "dateFin"=>'2024-02-12 00:00:00', "montant"=> "55000", "montantPromo"=> "45000", "dateFinPromo"=> '2024-01-11'],
            ["nom"=> "Cours du soir Session 2", "dateDebut"=> '2024-03-18 00:00:00', "dateFin"=>'2024-04-15 00:00:00', "montant"=> "55000", "montantPromo"=> "45000", "dateFinPromo"=> '2024-03-09'],
            ["nom"=> "Cours du journée Session 3", "dateDebut"=> '2024-04-08 00:00:00', "dateFin"=>'2024-05-02 00:00:00', "montant"=> "55000", "montantPromo"=> "45000", "dateFinPromo"=> '2024-03-30'],
        ];

        DB::table('prices')->insert([
            ["nom"=>'Adhesion Adulte', "montant"=> 15000],            
            ["nom"=>'Adhesion Étudiants', "montant"=> 12000],            
            ["nom"=>'Adhesion Enfants', "montant"=> 10000]
        ]);

        foreach ($Sessions as $Session) {
            DB::table('sessions')->insert($Session);
        }
        
        foreach ($Tarifs as $Tarif) {
            DB::table('prices')->insert(["nom"=>$Tarif['nom'], "montant"=> $Tarif['montant']]);
        }
        
        $prices = Price::all();
        $i = 4;
        $y = 0;
        foreach ($prices as $price) {
            if ($price->id == $i) {
            $price->levels()->attach($Tarifs[$y]['level_id']);
            $i += 1;
            }
        }
    }
}
