<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Stephenchen\Admin\Http\Backend\Admin\AdminModel;
use Stephenchen\Admin\Http\Backend\Permission\PermissionModel;
use Stephenchen\Admin\Http\Backend\Role\RoleModel;
use Stephenchen\Core\Utilities\Database;

class AdminSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     * @throws \Exception
     */
    public function run()
    {
        Database::truncateAllTables();

        $admin = AdminModel::create([
            'account'      => 'admin',
            'email'        => 'admin@gmail.com',
            'password'     => '123456',
            'display_name' => 'admin',
        ]);

        AdminModel::factory(10)->create();
        RoleModel::factory(10)->create();
        $this->seedPermissions();

        $role = RoleModel::findById(1);
        PermissionModel::all()->map(function ($permission) use ($role) {
            $role->givePermissionTo($permission);
        });

        AdminModel::all()->map(function ($admin) use ($role) {
            $admin->syncRoles([$role->name]);
        });
    }

    private function seedPermissions()
    {
        $auth = PermissionModel::create([
            'name' => 'auth',
            'path' => 'auth',
            'icon' => 'person',
        ]);

        $authUser = PermissionModel::create([
            'name'      => 'authUser',
            'path'      => 'authUser',
            'icon'      => 'authUser',
            'parent_id' => $auth->id,
        ]);

        $authRole = PermissionModel::create([
            'name'      => 'authRole',
            'path'      => 'authRole',
            'icon'      => 'authRole',
            'parent_id' => $auth->id,
        ]);

    }
}
