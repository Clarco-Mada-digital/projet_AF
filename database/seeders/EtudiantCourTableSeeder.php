<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EtudiantCourTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('etudiant_cours')->insert([
            ["cour_id"=>1,"etudiant_id"=>1,],
            ["cour_id"=>1,"etudiant_id"=>2,],
            ["cour_id"=>2,"etudiant_id"=>3,],
            ["cour_id"=>1,"etudiant_id"=>4,],
            ["cour_id"=>1,"etudiant_id"=>5,],
            ["cour_id"=>2,"etudiant_id"=>6,],
            ["cour_id"=>1,"etudiant_id"=>7,],
            ["cour_id"=>1,"etudiant_id"=>8,],
            ["cour_id"=>2,"etudiant_id"=>8,],
            ["cour_id"=>2,"etudiant_id"=>1,],
            ["cour_id"=>1,"etudiant_id"=>9,],
            ["cour_id"=>2,"etudiant_id"=>10,],
        ]);
    }
}
