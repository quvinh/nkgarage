<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Contracts\Permission;
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
        ModelsPermission::create(['name' => 'add']);
        ModelsPermission::create(['name' => 'edit']);
        ModelsPermission::create(['name' => 'delete']);
        ModelsPermission::create(['name' => 'read']);

        //create roles and assign
        $roleAdmin = Role::create(['name' => 'admin']);
        $roleCEO = Role::create(['name' => 'ceo']);
        $rolePresident = Role::create(['name' => 'president']);
        $roleChiefAccountant = Role::create(['name' => 'chiefAccountant']);
        $roleAccountant = Role::create(['name' => 'accountant']);
        $roleStoreKeeper = Role::create(['name' => 'storeKeeper']);

        $roleAdmin->givePermissionTo('add', 'edit', 'delete', 'read');

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
