<?php

namespace Database\Seeders;

use App\Models\Action;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ActionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Action::insert([
            ["name" => "Create", "color" => "#198754"],
            ["name" => "Update", "color" => "#0D6EFD"],
            ["name" => "Delete", "color" => "#DC3545"],
        ]);
    }
}
