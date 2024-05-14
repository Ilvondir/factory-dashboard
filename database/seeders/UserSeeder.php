<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::insert([
            ["first_name" => "Anesterian", "last_name" => "Sunstrider", "email" => "admin@fd.com", "password" => Hash::make("password"), "role_id" => 1],
            ["first_name" => "Sylvanas", "last_name" => "Windrunner", "email" => "viewer@fd.com", "password" => Hash::make("password"), "role_id" => 2]
        ]);
        
        User::factory(5)->create();
    }
}
