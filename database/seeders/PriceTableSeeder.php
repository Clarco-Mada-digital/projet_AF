<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PriceTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('prices')->insert([
            ["nom"=>'Adhesion Adulte', "montant"=> 15000],            
            ["nom"=>'Adhesion Étudiants', "montant"=> 12000],            
            ["nom"=>'Adhesion Enfants', "montant"=> 10000]
        ]);         
    }
}
