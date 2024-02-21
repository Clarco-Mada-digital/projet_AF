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
        $LEVELS = [
        'A définir',
        'A1.1 P1',
        'A1.1 P2',
        'A1.1 P3',
        'A1.1 P4',
        'A1.1 P5', 
        'A1.1 P6',
        'A1.1 P7', 
        'A1.1 P8',
        'A1.1 P9',
        'A1P1',
        'A1P2',
        'A1P3',
        'A1P4',
        'A2P1',
        'A2P2',
        'A2P3',
        'A2P4',
        'B1P1',
        'B1P2',
        'B1P3',
        'B1P4',
        'B1P5',
        'B2P1',
        'B2P2',
        'B2P3',
        'B2P4',
        'B2P5',
        'B2P6',
        'A1.1',
        'A1',
        'A2',
        'B1',
        'B2',
        'C1',
        'C2',
        ];
        

        foreach ($LEVELS as $LEVEL) {
            DB::table('levels')->insert([
                ["libelle"=> $LEVEL],
            ]);
        }
    }
}
