<?php

namespace Database\Seeders;

use App\Models\Position;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Position::insert([
            ["name" => "Automotive Production Engineer", "responsibilities" => fake()->text(rand(250, 500)), "department_id" => 1],
            ["name" => "Assembly Technician", "responsibilities" => fake()->text(rand(250, 500)), "department_id" => 1],
            ["name" => "Machine Operator", "responsibilities" => fake()->text(rand(250, 500)), "department_id" => 1],
            ["name" => "Food Technologist", "responsibilities" => fake()->text(rand(250, 500)), "department_id" => 2],
            ["name" => "Packaging Line Operator", "responsibilities" => fake()->text(rand(250, 500)), "department_id" => 2],
            ["name" => "Sanitation Inspector", "responsibilities" => fake()->text(rand(250, 500)), "department_id" => 2],
            ["name" => "Food Quality Analyst", "responsibilities" => fake()->text(rand(250, 500)), "department_id" => 2],
            ["name" => "Electronics Production Engineer", "responsibilities" => fake()->text(rand(250, 500)), "department_id" => 3],
            ["name" => "Test Engineer", "responsibilities" => fake()->text(rand(250, 500)), "department_id" => 3],
            ["name" => "Textile Production Manager", "responsibilities" => fake()->text(rand(250, 500)), "department_id" => 4],
            ["name" => "Weaving Machine Operator", "responsibilities" => fake()->text(rand(250, 500)), "department_id" => 4],
            ["name" => "Textile Designer", "responsibilities" => fake()->text(rand(250, 500)), "department_id" => 4],
            ["name" => "Human Resources Manager", "responsibilities" => fake()->text(rand(250, 500)), "department_id" => 5],
            ["name" => "Recruitment Specialist", "responsibilities" => fake()->text(rand(250, 500)), "department_id" => 5],
        ]);
    }
}
