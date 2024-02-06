<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                "nom"=>'Jhon', 
                "prenom"=>'Doe',
                "sexe"=>'M',
                "nationalite"=>'Malagasy',
                "telephone1"=>'+223566849',
                "adresse"=>'125 rue de belle imagine',
                "email"=>'jhon@doe.com',
                "password"=>'$2y$12$PT23r3.Fme7vpdQzfElnBOTTZn7eyHsmGXJ7mdrytkOATtc6c/RJC',
            ],
        ]);
    }
}
