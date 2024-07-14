<?php

namespace Database\Seeders;

use App\Models\Action;
use App\Models\Material;
use App\Models\Product;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
            DepartmentSeeder::class,
            PositionSeeder::class,
            WorkerSeeder::class,
            MaterialSeeder::class,
            ProductSeeder::class,
            ActionSeeder::class,
//            LogSeeder::class
        ]);

        $materialCount = Material::count();

        for ($i = 1; $i <= Product::count(); $i++) {
            $rand1 = random_int(1, $materialCount);
            $rand2 = $rand1;
            while ($rand2 == $rand1) $rand2 = random_int(1, $materialCount);

            DB::insert("INSERT INTO products_materials (product_id, material_id) VALUES (?, ?);", [$i, $rand1]);
            DB::insert("INSERT INTO products_materials (product_id, material_id) VALUES (?, ?);", [$i, $rand2]);

            if (random_int(0, 1) == 1) {
                $rand3 = random_int(1, $materialCount);
                while ($rand1 == $rand3 || $rand2 == $rand3) $rand3 = random_int(1, $materialCount);

                DB::insert("INSERT INTO products_materials (product_id, material_id) VALUES (?, ?);", [$i, $rand3]);
            }
        }
    }
}
