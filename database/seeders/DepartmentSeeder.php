<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Department::insert([
            ["name" => "Automotive Production"],
            ["name" => "Food Production"],
            ["name" => "Electronics Production"],
            ["name" => "Textile Production"],
            ["name" => "Human Resource"]
        ]);
    }
}
