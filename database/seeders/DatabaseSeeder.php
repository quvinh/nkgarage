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
        // \App\Models\User::factory(10)->create();
        // factory(User::class)->create();

        // DB::table('users')->insert([
        //     [
        //         'username' => 'admin',
        //         'email' => 'admin@gmail.com',
        //         'password' => bcrypt('123456'),
        //         'fullname' => 'ADMIN',
        //         'phone' => '0987654321',
        //         'created_at' => now(),
        //         'updated_at' => now(),
        //         'email_verified_at' => now()
        //     ]
        // ]);

        // DB::table('permissions')->insert([
        //     ['name' => 'Xem'],
        //     ['name' => 'Thêm'],
        //     ['name' => 'Sửa'],
        //     ['name' => 'Xoá'],
        //     ['name' => 'Xoá vĩnh viễn'],
        // ]);

        // DB::table('roles')->insert([
        //     ['name' => 'admin']
        // ]);

        // DB::table('role_users')->insert([
        //     [
        //         'user_id' => 1,
        //         'roles_id' => 1
        //     ],
        // ]);

        // DB::table('permission_roles')->insert([
        //     ['permission_id' => 1, 'roles_id' => 1],
        //     ['permission_id' => 2, 'roles_id' => 1],
        //     ['permission_id' => 3, 'roles_id' => 1],
        //     ['permission_id' => 4, 'roles_id' => 1],
        //     ['permission_id' => 5, 'roles_id' => 1],
        // ]);

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
            ]
        ]);
    }
}
