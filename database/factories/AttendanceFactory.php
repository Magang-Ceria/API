<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Attendance>
 */
class AttendanceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'morningtime' => fake()->time(),
            'morningstatus' => fake()->randomElement(['Absent', 'Terlambat', 'Izin', 'Masuk']),
            'afternoontime' => fake()->time(),
            'afternoonstatus' => fake()->randomElement(['Absent', 'Terlambat', 'Izin', 'Masuk']),
            'proof' => fake()->image('storage', 640, 480),
            'date_id' => 2
        ];
    }
}
