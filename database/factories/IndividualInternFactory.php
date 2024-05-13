<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\IndividualIntern>
 */
class IndividualInternFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'address' => fake()->city(),
            'institution' => 'Universitas '.fake()->city(),
            'startperiode' => fake()->dateTimeBetween('-4 months'),
            'endperiode' => fake()->dateTimeBetween('-1 week'),
            'status' => fake()->randomElement(['pending', 'active'])
        ];
    }
}
