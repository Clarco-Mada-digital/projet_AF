<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;
use Database\Seeders\RoleTableSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(RoleTableSeeder::class);

        $this->call(UserTableSeeder::class);

        \App\Models\User::factory(2)->create();
        
        \App\Models\Professeur::factory(3)-> create();

        $this->call(LevelsTableSeeder::class);
        $this->call(CategoriesTableSeeder::class);
        $this->call(PriceTableSeeder::class);
        // $this->call(CourTableSeeder::class);

        $user1 = \App\Models\User::find(1);
        $user1->assignRole('Super-Admin');
        $user2 = \App\Models\User::find(2);
        $user2->assignRole('Admin');
        $user3 = \App\Models\User::find(3);
        $user3->assignRole('Manager');

        // \App\Models\Etudiant::factory(10)->create();
        

        // $this->call(EtudiantCourTableSeeder::class);
        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
