<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('permissions')->insert([
            ["nom"=>'SuperAdmin'],
            ["nom"=>'Admin'],
            ["nom"=>'Manager'],
        ]);
    }
}
