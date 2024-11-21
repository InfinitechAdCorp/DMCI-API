<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run()
    {
        $admin = Role::create(['name' => 'admin']);
        $editor = Role::create(['name' => 'editor']);

        $viewUsers = Permission::create(['name' => 'view_users']);
        $editUsers = Permission::create(['name' => 'edit_users']);

        $admin->permissions()->attach([$viewUsers->id, $editUsers->id]);
        $editor->permissions()->attach([$viewUsers->id]);
    }
}

