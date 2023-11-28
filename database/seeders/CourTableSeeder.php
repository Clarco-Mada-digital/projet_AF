<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CourTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('cours')->insert([
            [
                "code"=>'CFADON1', 
                "libelle"=>'Cour français', 
                "categorie"=>'ADO',
                "salle"=>'S 001',
                "horaire"=> "Mercredi-14h-15h | Vendredi-14h-15h",
                "professeur_id"=>1,
                "level_id"=>1,
            ],
            [
                "code"=>'CMADON1', 
                "libelle"=>'Cour malagasy', 
                "categorie"=>'ADO',
                "salle"=>'S 002',
                "horaire"=> "Mercredi-14h-15h | Vendredi-14h-15h",
                "professeur_id"=>2,
                "level_id"=>1,
            ],
        ]);
    }
}
