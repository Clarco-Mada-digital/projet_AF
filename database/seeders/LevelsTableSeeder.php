<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LevelsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('levels')->insert([
            ["libelle"=>'À définir'],
            ["libelle"=>'A1'],
            ["libelle"=>'A2'],
            ["libelle"=>'B1'],
            ["libelle"=>'B2'],
            ["libelle"=>'C1'],
            ["libelle"=>'C2'],
        ]);
    }
}
