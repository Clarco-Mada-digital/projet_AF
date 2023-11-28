<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(roleTableSeeder::class);

        $this->call(UserTableSeeder::class);
        \App\Models\User::factory(3)->create();
        
        \App\Models\Professeur::factory(3)-> create();

        $this->call(LevelsTableSeeder::class);
        // $this->call(CourTableSeeder::class);

        
        \App\Models\Etudiant::factory(10)->create();
        

        $this->call(EtudiantCourTableSeeder::class);
        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
