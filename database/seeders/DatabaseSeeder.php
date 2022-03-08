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

        DB::table('items')->insert([
            [
                'id' => 'BDH8',
                'category_id' => 1,
                'name' => 'Bóng đèn H8',
                'unit' => 'Cái',
                'note' => ''
            ],
            [
                'id' => 'BDH880',
                'category_id' => 1,
                'name' => 'Bóng đèn H880',
                'unit' => 'Cái',
                'note' => ''
            ],
            [
                'id' => 'CBL4',
                'category_id' => 2,
                'name' => 'Cảm biến lùi 4 mắt',
                'unit' => 'Bộ',
                'note' => ''
            ],
            [
                'id' => 'CBL6',
                'category_id' => 2,
                'name' => 'Cảm biến lùi 6 mắt',
                'unit' => 'Bộ',
                'note' => ''
            ],
            [
                'id' => 'LOCDIno',
                'category_id' => 3,
                'name' => 'Lọc dầu Innova',
                'unit' => 'Cái',
                'note' => ''
            ],
            [
                'id' => 'LOCDNis',
                'category_id' => 3,
                'name' => 'Lọc dầu Nissan',
                'unit' => 'Cái',
                'note' => ''
            ],
            [
                'id' => 'LOCDHCam',
                'category_id' => 4,
                'name' => 'Lọc điều hoà Camry',
                'unit' => 'Cái',
                'note' => ''
            ],
            [
                'id' => 'LOCDHMaz',
                'category_id' => 4,
                'name' => 'Lọc điều hoà Mazda',
                'unit' => 'Cái',
                'note' => ''
            ],
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

        DB::table('suppliers')->insert([
            [
                'code' => 'CODE001',
                'name' => 'Cửa hàng vật tư/phụ tùng HP'
            ],
        ]);
    }
}
