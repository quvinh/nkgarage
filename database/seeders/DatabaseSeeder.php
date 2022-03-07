<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->insert([
            ['name' => 'Bóng đèn'],
            ['name' => 'Cảm biến'],
            ['name' => 'Lọc nhiên liệu'],
            ['name' => 'Lọc điều hoà'],
        ]);

        DB::table('warehouses')->insert([
            [
                'name' => 'Nam Khánh Garage',
                'location' => 'Lê Hồng Phong',
                'status' => true
            ],
        ]);

        DB::table('shelves')->insert([
            [
                'name' => 'NK_GIA1',
                'warehouse_id' => 1,
                'status' => true,
                'position' => 'Garage'
            ],
            [
                'name' => 'NK_GIA2',
                'warehouse_id' => 1,
                'status' => true,
                'position' => 'Garage'
            ],
            [
                'name' => 'NK_GIA3',
                'warehouse_id' => 1,
                'status' => true,
                'position' => 'Garage'
            ],
            [
                'name' => 'NK_GIA4',
                'warehouse_id' => 1,
                'status' => true,
                'position' => 'Garage'
            ]
        ]);
    }
}
