<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Log>
 */
class LogFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "operation" => fake()->text(),
            "occured" => fake()->date(),
            "user_id" => fake()->numberBetween(1, 7),
            "action_id" => fake()->numberBetween(1, 3)
        ];
    }
}
