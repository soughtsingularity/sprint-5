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
        $userRole = Role::firstOrCreate(['name' => 'user', 'guard_name' => 'api']);
        $adminRole = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'api']);

        $deleteAccountPermission = Permission::firstOrCreate(['name' => 'delete-account', 'guard_name' => 'api']);
        $createCoursePermission = Permission::firstOrCreate(['name' => 'create-course', 'guard_name' => 'api']);
        $enrollCoursePermission = Permission::firstOrCreate(['name' => 'enroll-course', 'guard_name' => 'api']);
        $unenrollCoursePermission = Permission::firstOrCreate(['name' => 'unenroll-course', 'guard_name' => 'api']);


        $userRole->givePermissionTo($deleteAccountPermission, $enrollCoursePermission);

        $adminRole->givePermissionTo($createCoursePermission);
    }
}
