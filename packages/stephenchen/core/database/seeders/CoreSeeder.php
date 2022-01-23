<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Stephenchen\Core\Http\Backend\Admin\AdminModel;
use Stephenchen\Core\Http\Backend\Permission\PermissionModel;
use Stephenchen\Core\Http\Backend\Role\RoleModel;

class CoreSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     * @throws \Exception
     */
    public function run()
    {
        $admin = AdminModel::create([
            'account'      => 'admin',
            'email'        => 'admin@gmail.com',
            'password'     => 'aaa111222',
            'display_name' => 'admin',
        ]);

        AdminModel::factory(10)->create();
        RoleModel::factory(10)->create();
        PermissionModel::factory(10)->create();

        $role = RoleModel::findById(1);
        PermissionModel::all()->map(function ($permission) use ($role) {
            $role->givePermissionTo($permission);
        })->toArray();

        $admin->syncRoles([$role->name]);
    }
}
