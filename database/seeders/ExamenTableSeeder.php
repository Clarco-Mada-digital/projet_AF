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
            ["libelle"=>"DELF & DALF", "price_id"=> 4, 'level_id' => 31, 'session_id' => 4],
            ["libelle"=>"DELF & DALF", "price_id"=> 5, 'level_id' => 33, 'session_id' => 4],
        ];

        // creation d'examen
        foreach ($EXAMENS as $exam) {
            DB::table('examens')->insert($exam);
        }

    }
}
