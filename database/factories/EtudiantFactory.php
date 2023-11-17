<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Etudiant>
 */
class EtudiantFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nom' => fake()->lastName(),
            'prenom' => fake()->firstName(),
            'sexe' => fake()->randomElement(["M", "F"]),
            'nationalite' => fake()->country(),
            'telephone1' => fake()->phoneNumber(),
            'adresse' => fake()->address(),
            'email' => fake()->unique()->safeEmail(),
            'numCarte' => fake()->unique()->randomNumber(),
            'user_id' => rand(1, 3),
            'level_id' => rand(1, 3),
        ];
    }
}
