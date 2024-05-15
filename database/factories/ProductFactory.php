<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->unique()->word();
        
        for ($i = 0; $i < rand(0, 3); $i++) {
            $name .= " " . fake()->unique()->word();
        }

        return [
            "name" => ucfirst($name),
            "price" => fake()->numberBetween(1000, 999999) / 100,
            "department_id" => fake()->numberBetween(1, 4)
        ];
    }
}
