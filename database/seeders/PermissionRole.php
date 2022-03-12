<?php

namespace Database\Seeders;

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

        //Import
        ModelsPermission::create(['name' => 'Thêm phiếu nhập 1']);
        ModelsPermission::create(['name' => 'Sửa phiếu nhập 1']);
        ModelsPermission::create(['name' => 'Xoá phiếu nhập 1']);
        ModelsPermission::create(['name' => 'Xem phiếu nhập 1']);
        ModelsPermission::create(['name' => 'Duyệt phiếu nhập 1']);

        //Export
        ModelsPermission::create(['name' => 'Thêm phiếu xuất 1']);
        ModelsPermission::create(['name' => 'Sửa phiếu xuất 1']);
        ModelsPermission::create(['name' => 'Xoá phiếu xuất 1']);
        ModelsPermission::create(['name' => 'Xem phiếu xuất 1']);
        ModelsPermission::create(['name' => 'Duyệt phiếu xuất 1']);

        //Transfer
        ModelsPermission::create(['name' => 'Thêm phiếu chuyển 1']);
        ModelsPermission::create(['name' => 'Sửa phiếu chuyển 1']);
        ModelsPermission::create(['name' => 'Xoá phiếu chuyển 1']);
        ModelsPermission::create(['name' => 'Xem phiếu chuyển 1']);
        ModelsPermission::create(['name' => 'Duyệt phiếu chuyển 1']);

        //Inventory
        ModelsPermission::create(['name' => 'Thêm phiếu kiểm kê 1']);
        ModelsPermission::create(['name' => 'Sửa phiếu kiểm kê 1']);
        ModelsPermission::create(['name' => 'Xoá phiếu kiểm kê 1']);
        ModelsPermission::create(['name' => 'Xem phiếu kiểm kê 1']);
        ModelsPermission::create(['name' => 'Duyệt phiếu kiểm kê 1']);

        //Warehouse
        ModelsPermission::create(['name' => 'Thêm kho']);
        ModelsPermission::create(['name' => 'Sửa kho']);
        ModelsPermission::create(['name' => 'Xoá kho']);
        ModelsPermission::create(['name' => 'Xem kho']);

        //Shelf
        ModelsPermission::create(['name' => 'Thêm giá/kệ 1']);
        ModelsPermission::create(['name' => 'Sửa giá/kệ 1']);
        ModelsPermission::create(['name' => 'Xoá giá/kệ 1']);
        ModelsPermission::create(['name' => 'Xem giá/kệ 1']);

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
        ModelsPermission::create(['name' => 'Thêm báo cáo']);
        ModelsPermission::create(['name' => 'Sửa báo cáo']);
        ModelsPermission::create(['name' => 'Xoá báo cáo']);
        ModelsPermission::create(['name' => 'Xem báo cáo']);

        //create roles and assign
        $roleAdmin = Role::create(['name' => 'admin']);
        $roleCEO = Role::create(['name' => 'Tổng giám đốc']);
        $rolePresident = Role::create(['name' => 'Giám đốc 1']);
        $roleChiefAccountant = Role::create(['name' => 'Kế toán trưởng']);
        $roleAccountant = Role::create(['name' => 'Kế toán 1']);
        $roleStoreKeeper = Role::create(['name' => 'Thủ kho 1']);

        $roleAdmin->givePermissionTo(ModelsPermission::all());

        $roleCEO->givePermissionTo(ModelsPermission::all());

        $rolePresident->givePermissionTo(
            'Thêm phiếu nhập 1', 'Sửa phiếu nhập 1', 'Xoá phiếu nhập 1', 'Xem phiếu nhập 1', 'Duyệt phiếu nhập 1',
            'Thêm phiếu xuất 1', 'Sửa phiếu xuất 1', 'Xoá phiếu xuất 1', 'Xem phiếu xuất 1', 'Duyệt phiếu xuất 1',
            'Thêm phiếu chuyển 1', 'Sửa phiếu chuyển 1', 'Xoá phiếu chuyển 1', 'Xem phiếu chuyển 1', 'Duyệt phiếu chuyển 1',
            'Thêm phiếu kiểm kê 1', 'Sửa phiếu kiểm kê 1', 'Xoá phiếu kiểm kê 1', 'Xem phiếu kiểm kê 1', 'Duyệt phiếu kiểm kê 1',
            'Thêm kho', 'Sửa kho', 'Xoá kho', 'Xem kho',
            'Thêm giá/kệ 1', 'Sửa giá/kệ 1', 'Xoá giá/kệ 1', 'Xem giá/kệ 1',
            'Thêm loại vật tư', 'Sửa loại vật tư', 'Xoá loại vật tư', 'Xem loại vật tư',
            'Thêm nhà cung cấp', 'Sửa nhà cung cấp', 'Xoá nhà cung cấp', 'Xem nhà cung cấp',
            'Thêm thông báo', 'Sửa thông báo', 'Xoá thông báo', 'Xem thông báo',
            'Thêm báo cáo', 'Sửa báo cáo', 'Xoá báo cáo', 'Xem báo cáo',
        );

        $roleChiefAccountant->givePermissionTo(
            'Thêm phiếu nhập 1', 'Sửa phiếu nhập 1', 'Xoá phiếu nhập 1', 'Xem phiếu nhập 1', 'Duyệt phiếu nhập 1',
            'Thêm phiếu xuất 1', 'Sửa phiếu xuất 1', 'Xoá phiếu xuất 1', 'Xem phiếu xuất 1', 'Duyệt phiếu xuất 1',
            'Thêm phiếu chuyển 1', 'Sửa phiếu chuyển 1', 'Xoá phiếu chuyển 1', 'Xem phiếu chuyển 1', 'Duyệt phiếu chuyển 1',
            'Thêm phiếu kiểm kê 1', 'Sửa phiếu kiểm kê 1', 'Xoá phiếu kiểm kê 1', 'Xem phiếu kiểm kê 1', 'Duyệt phiếu kiểm kê 1',
            'Thêm kho', 'Sửa kho', 'Xoá kho', 'Xem kho',
            'Thêm giá/kệ 1', 'Sửa giá/kệ 1', 'Xoá giá/kệ 1', 'Xem giá/kệ 1',
            'Thêm loại vật tư', 'Sửa loại vật tư', 'Xoá loại vật tư', 'Xem loại vật tư',
            'Thêm nhà cung cấp', 'Sửa nhà cung cấp', 'Xoá nhà cung cấp', 'Xem nhà cung cấp',
            'Thêm thông báo', 'Sửa thông báo', 'Xoá thông báo', 'Xem thông báo',
            'Thêm báo cáo', 'Sửa báo cáo', 'Xoá báo cáo', 'Xem báo cáo',
        );

        $roleAccountant->givePermissionTo(
            'Thêm phiếu nhập 1', 'Sửa phiếu nhập 1', 'Xem phiếu nhập 1', 'Xem phiếu nhập 1', 'Duyệt phiếu nhập 1',
            'Thêm phiếu xuất 1', 'Sửa phiếu xuất 1', 'Xem phiếu xuất 1', 'Xem phiếu xuất 1', 'Duyệt phiếu xuất 1',
            'Thêm phiếu chuyển 1', 'Sửa phiếu chuyển 1', 'Xem phiếu chuyển 1', 'Xem phiếu chuyển 1', 'Duyệt phiếu chuyển 1',
            'Thêm phiếu kiểm kê 1', 'Sửa phiếu kiểm kê 1', 'Xem phiếu kiểm kê 1',
            'Thêm nhà cung cấp', 'Sửa nhà cung cấp', 'Xoá nhà cung cấp', 'Xem nhà cung cấp',
            'Thêm thông báo', 'Xem thông báo',
            'Thêm báo cáo', 'Sửa báo cáo', 'Xem báo cáo',
        );

        $roleStoreKeeper->givePermissionTo(
            'Thêm phiếu nhập 1', 'Sửa phiếu nhập 1', 'Xem phiếu nhập 1',
            'Thêm phiếu xuất 1', 'Sửa phiếu xuất 1', 'Xem phiếu xuất 1',
            'Thêm phiếu chuyển 1', 'Sửa phiếu chuyển 1', 'Xem phiếu chuyển 1',
            'Thêm phiếu kiểm kê 1', 'Sửa phiếu kiểm kê 1', 'Xem phiếu kiểm kê 1',
            'Thêm nhà cung cấp', 'Sửa nhà cung cấp', 'Xoá nhà cung cấp', 'Xem nhà cung cấp',
            'Thêm thông báo', 'Xem thông báo',
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
    }
}
