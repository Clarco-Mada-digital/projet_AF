<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ExamenTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $EXAMENS = [
            ["libelle"=>"DELF & DALF", "price_id"=> 4, 'level_id' => 31],
            ["libelle"=>"DELF & DALF", "price_id"=> 5, 'level_id' => 33],
        ];

        // creation d'examen
        foreach ($EXAMENS as $exam) {
            DB::table('examens')->insert(["libelle"=>$exam['libelle'], "price_id" => $exam['price_id'], "level_id" => $exam['level_id']]);
        }

    }
}
