<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $USERS = [
            [
                "nom" => 'Bryan',
                "prenom" => 'Clark',
                "sexe" => 'M',
                "telephone1" => '+223566849',
                "adresse" => '125 rue de belle imagine',
                "email" => 'bryan@admin.com',
                "password" => Hash::make('my angel'),
            ],
            [
                "nom" => 'Jhon',
                "prenom" => 'Doe',
                "sexe" => 'M',
                "telephone1" => '+223566849',
                "adresse" => '125 dream street',
                "email" => 'jhon@doe.com',
                "password" => '$2y$12$PT23r3.Fme7vpdQzfElnBOTTZn7eyHsmGXJ7mdrytkOATtc6c/RJC',
            ],
        ];
        foreach ($USERS as $USER) {
            DB::table('users')->insert($USER);
        }
    }
}
