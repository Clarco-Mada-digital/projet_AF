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
                "nom"=>'Cour français', 
                "categorie"=>'ADO',
                "sale"=>'S 001',
                "horaire"=> "Mercredi-14h-15h, Vendredi-14h-15h",
                "professeur_id"=>1,
                "level_id"=>1,
            ],
            [
                "nom"=>'Cour malagasy', 
                "categorie"=>'ADO',
                "sale"=>'S 002',
                "horaire"=> "Mercredi-14h-15h, Vendredi-14h-15h",
                "professeur_id"=>2,
                "level_id"=>1,
            ],
        ]);
    }
}
