<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role = Role::firstOrCreate(['name' => 'user', 'guard_name' => 'api']);
        $permission = Permission::firstOrCreate(['name' => 'delete-account', 'guard_name' => 'api']);
        $role->givePermissionTo($permission);
    }
}
