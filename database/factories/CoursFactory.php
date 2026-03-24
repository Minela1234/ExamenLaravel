<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Cours>
 */
class CoursFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'libelle'        => $this->faker->sentence(1),
            'professeur'     => $this->faker->name(),
            // nombre entre 10 et 50
            'volume_horaire' => $this->faker->numberBetween(10, 50),
        ];
    }
}
