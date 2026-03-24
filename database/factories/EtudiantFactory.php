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
            'prenom'         => $this->faker->firstName(),
            'nom'            => $this->faker->lastName(),
            'email'          => $this->faker->unique()->safeEmail(),
            // date il y a au moins 18 ans
            'date_naissance' => $this->faker->date('Y-m-d', '-18 years'),
        ];
    }
}
