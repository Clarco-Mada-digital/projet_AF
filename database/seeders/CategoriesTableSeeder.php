<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('categories')->insert([
            ["id" => 1, "libelle"=>'Jeunesses'],
            ["id" => 2, "libelle"=>'Professeur AF'],
            ["id" => 3, "libelle"=>'Professionnel AF'],
            ["id" => 4, "libelle"=>'Mécénat'],
            ["id" => 5, "libelle"=>'Lycéen/Étudiants'],
            ["id" => 6, "libelle"=>'Collégiens'],
            ["id" => 7, "libelle"=>'Adultes'],
            ["id" => 8, "libelle"=>'Validé à lire'],
            // ["libelle"=>'Enfants'],
        ]);
    }
}
