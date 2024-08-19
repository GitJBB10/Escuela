<?php

namespace Database\Seeders;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $role = Role::create(['name' => 'admin']);

        $permission_create_role = Permission::create(['name'=> 'create roles']);
        $permission_read_role = Permission::create(['name'=> 'read roles']);
        $permission_update_role = Permission::create(['name'=> 'update roles']);
        $permission_delete_role = Permission::create(['name'=> 'delete roles']);

        $permissions_admin = [$permission_create_role,$permission_read_role,$permission_update_role,$permission_delete_role];

        $role_admin->syncPermissions($permissions_admin);
    
    }
}
