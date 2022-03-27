<?php

namespace Database\Seeders;

use App\Models\Manager;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission as ModelsPermission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class PermissionRole extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        //create permission
        //Account
        ModelsPermission::create(['name' => 'Thêm tài khoản']);
        ModelsPermission::create(['name' => 'Sửa tài khoản']);
        ModelsPermission::create(['name' => 'Xoá tài khoản']);
        ModelsPermission::create(['name' => 'Xem tài khoản']);

        //Warehouse
        ModelsPermission::create(['name' => 'Thêm kho']);
        ModelsPermission::create(['name' => 'Sửa kho']);
        ModelsPermission::create(['name' => 'Xoá kho']);
        ModelsPermission::create(['name' => 'Xem kho']);

        //Item
        ModelsPermission::create(['name' => 'Thêm vật tư']);
        ModelsPermission::create(['name' => 'Sửa vật tư']);
        ModelsPermission::create(['name' => 'Xoá vật tư']);
        ModelsPermission::create(['name' => 'Xem vật tư']);

        //Import
        ModelsPermission::create(['name' => 'Thêm phiếu nhập']);
        ModelsPermission::create(['name' => 'Sửa phiếu nhập']);
        ModelsPermission::create(['name' => 'Xoá phiếu nhập']);
        ModelsPermission::create(['name' => 'Xem phiếu nhập']);
        ModelsPermission::create(['name' => 'Duyệt phiếu nhập']);

        //Export
        ModelsPermission::create(['name' => 'Thêm phiếu xuất']);
        ModelsPermission::create(['name' => 'Sửa phiếu xuất']);
        ModelsPermission::create(['name' => 'Xoá phiếu xuất']);
        ModelsPermission::create(['name' => 'Xem phiếu xuất']);
        ModelsPermission::create(['name' => 'Duyệt phiếu xuất']);

        //Transfer
        ModelsPermission::create(['name' => 'Thêm phiếu chuyển']);
        ModelsPermission::create(['name' => 'Sửa phiếu chuyển']);
        ModelsPermission::create(['name' => 'Xoá phiếu chuyển']);
        ModelsPermission::create(['name' => 'Xem phiếu chuyển']);
        ModelsPermission::create(['name' => 'Duyệt phiếu chuyển']);

        //Shelf
        ModelsPermission::create(['name' => 'Thêm giá/kệ']);
        ModelsPermission::create(['name' => 'Sửa giá/kệ']);
        ModelsPermission::create(['name' => 'Xoá giá/kệ']);
        ModelsPermission::create(['name' => 'Xem giá/kệ']);

        //Category
        ModelsPermission::create(['name' => 'Thêm loại vật tư']);
        ModelsPermission::create(['name' => 'Sửa loại vật tư']);
        ModelsPermission::create(['name' => 'Xoá loại vật tư']);
        ModelsPermission::create(['name' => 'Xem loại vật tư']);

        //Supplier
        ModelsPermission::create(['name' => 'Thêm nhà cung cấp']);
        ModelsPermission::create(['name' => 'Sửa nhà cung cấp']);
        ModelsPermission::create(['name' => 'Xoá nhà cung cấp']);
        ModelsPermission::create(['name' => 'Xem nhà cung cấp']);

        //Notification
        ModelsPermission::create(['name' => 'Thêm thông báo']);
        ModelsPermission::create(['name' => 'Sửa thông báo']);
        ModelsPermission::create(['name' => 'Xoá thông báo']);
        ModelsPermission::create(['name' => 'Xem thông báo']);

        //Report
        // ModelsPermission::create(['name' => 'Thêm báo cáo']);
        // ModelsPermission::create(['name' => 'Sửa báo cáo']);
        // ModelsPermission::create(['name' => 'Xoá báo cáo']);
        // ModelsPermission::create(['name' => 'Xem báo cáo']);

        //Inventory
        ModelsPermission::create(['name' => 'Thêm phiếu kiểm kê']);
        ModelsPermission::create(['name' => 'Sửa phiếu kiểm kê']);
        ModelsPermission::create(['name' => 'Xoá phiếu kiểm kê']);
        ModelsPermission::create(['name' => 'Xem phiếu kiểm kê']);
        ModelsPermission::create(['name' => 'Duyệt phiếu kiểm kê']);

        //Statistical
        ModelsPermission::create(['name' => 'Thống kê']);


        //create roles and assign
        $roleAdmin = Role::create(['name' => 'admin']);
        $roleCEO = Role::create(['name' => 'Tổng giám đốc']);
        $rolePresident = Role::create(['name' => 'Giám đốc']);
        $roleChiefAccountant = Role::create(['name' => 'Kế toán trưởng']);
        $roleAccountant = Role::create(['name' => 'Kế toán']);
        $roleStoreKeeper = Role::create(['name' => 'Thủ kho']);

        $roleAdmin->givePermissionTo(ModelsPermission::all());
        $roleCEO->givePermissionTo(ModelsPermission::all());

        $rolePresident->givePermissionTo(
            'Thêm phiếu nhập', 'Sửa phiếu nhập', 'Xoá phiếu nhập', 'Xem phiếu nhập', 'Duyệt phiếu nhập',
            'Thêm phiếu xuất', 'Sửa phiếu xuất', 'Xoá phiếu xuất', 'Xem phiếu xuất', 'Duyệt phiếu xuất',
            'Thêm phiếu chuyển', 'Sửa phiếu chuyển', 'Xoá phiếu chuyển', 'Xem phiếu chuyển', 'Duyệt phiếu chuyển',
            'Thêm phiếu kiểm kê', 'Sửa phiếu kiểm kê', 'Xoá phiếu kiểm kê', 'Xem phiếu kiểm kê', 'Duyệt phiếu kiểm kê',
            'Thêm kho', 'Sửa kho', 'Xoá kho', 'Xem kho',
            'Thêm giá/kệ', 'Sửa giá/kệ', 'Xoá giá/kệ', 'Xem giá/kệ',
            'Thêm loại vật tư', 'Sửa loại vật tư', 'Xoá loại vật tư', 'Xem loại vật tư',
            'Thêm vật tư', 'Sửa vật tư', 'Xoá vật tư', 'Xem vật tư',
            'Thêm nhà cung cấp', 'Sửa nhà cung cấp', 'Xoá nhà cung cấp', 'Xem nhà cung cấp',
            'Thêm thông báo', 'Sửa thông báo', 'Xoá thông báo', 'Xem thông báo',
            'Thống kê'
            // 'Thêm báo cáo', 'Sửa báo cáo', 'Xoá báo cáo', 'Xem báo cáo',
        );

        $roleChiefAccountant->givePermissionTo(
            'Thêm phiếu nhập', 'Sửa phiếu nhập', 'Xoá phiếu nhập', 'Xem phiếu nhập', 'Duyệt phiếu nhập',
            'Thêm phiếu xuất', 'Sửa phiếu xuất', 'Xoá phiếu xuất', 'Xem phiếu xuất', 'Duyệt phiếu xuất',
            'Thêm phiếu chuyển', 'Sửa phiếu chuyển', 'Xoá phiếu chuyển', 'Xem phiếu chuyển', 'Duyệt phiếu chuyển',
            'Thêm phiếu kiểm kê', 'Sửa phiếu kiểm kê', 'Xoá phiếu kiểm kê', 'Xem phiếu kiểm kê', 'Duyệt phiếu kiểm kê',
            'Thêm kho', 'Sửa kho', 'Xoá kho', 'Xem kho',
            'Thêm giá/kệ', 'Sửa giá/kệ', 'Xoá giá/kệ', 'Xem giá/kệ',
            'Thêm loại vật tư', 'Sửa loại vật tư', 'Xoá loại vật tư', 'Xem loại vật tư',
            'Thêm nhà cung cấp', 'Sửa nhà cung cấp', 'Xoá nhà cung cấp', 'Xem nhà cung cấp',
            'Thêm thông báo', 'Sửa thông báo', 'Xoá thông báo', 'Xem thông báo',
            'Thống kê'
            // 'Thêm báo cáo', 'Sửa báo cáo', 'Xoá báo cáo', 'Xem báo cáo',
        );

        $roleAccountant->givePermissionTo(
            'Thêm phiếu nhập', 'Sửa phiếu nhập', 'Xem phiếu nhập', 'Xem phiếu nhập', 'Duyệt phiếu nhập',
            'Thêm phiếu xuất', 'Sửa phiếu xuất', 'Xem phiếu xuất', 'Xem phiếu xuất', 'Duyệt phiếu xuất',
            'Thêm phiếu chuyển', 'Sửa phiếu chuyển', 'Xem phiếu chuyển', 'Xem phiếu chuyển', 'Duyệt phiếu chuyển',
            'Thêm phiếu kiểm kê', 'Sửa phiếu kiểm kê', 'Xem phiếu kiểm kê',
            'Thêm nhà cung cấp', 'Sửa nhà cung cấp', 'Xem nhà cung cấp',
            'Thêm thông báo', 'Xem thông báo',
            'Thống kê'
            // 'Thêm báo cáo', 'Sửa báo cáo', 'Xem báo cáo',
        );

        $roleStoreKeeper->givePermissionTo(
            'Thêm phiếu nhập', 'Sửa phiếu nhập', 'Xem phiếu nhập',
            'Thêm phiếu xuất', 'Sửa phiếu xuất', 'Xem phiếu xuất',
            'Thêm phiếu chuyển', 'Sửa phiếu chuyển', 'Xem phiếu chuyển',
            'Thêm phiếu kiểm kê', 'Sửa phiếu kiểm kê', 'Xem phiếu kiểm kê',
            'Thêm nhà cung cấp', 'Sửa nhà cung cấp', 'Xoá nhà cung cấp', 'Xem nhà cung cấp',
            'Thêm thông báo', 'Xem thông báo',
            'Thống kê'
        );

        //create admin
        $admin = User::create([
            'username' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('123456'),
            'fullname' => 'ADMIN',
            'phone' => '0987654321',
            'created_at' => now(),
            'updated_at' => now(),
            'email_verified_at' => now()
        ]);
        $admin->assignRole($roleAdmin);

        Manager::create([
            'user_id' => 1,
            'warehouse_id' => 1,
        ]);
    }
}
