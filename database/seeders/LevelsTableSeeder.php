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
            ["nom"=>'À définir'],
            ["nom"=>'Debutant'],
            ["nom"=>'Intermédiaire'],
            ["nom"=>'Avancé'],
        ]);
    }
}
