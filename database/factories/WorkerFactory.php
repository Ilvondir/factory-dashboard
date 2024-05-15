<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Worker>
 */
class WorkerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            "salary" => fake()->numberBetween(100000, 999999) / 100,
            "hired" => fake()->date(),
            "email" => fake()->unique()->email(),
            "address" => fake()->unique()->streetAddress(),
            "phone_number" => fake()->phoneNumber(),
            "position_id" => fake()->numberBetween(1, 14)
        ];
    }
}
