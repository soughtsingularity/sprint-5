<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(RolesAndPermissionsSeeder::class);

        $user = User::factory()->create([
            'username' => 'test_user',
            'email' => 'user@test.com',
            'password' => bcrypt('password'),
            'role' => 'user',
        ]);

        $user->assignRole('user');


        $admin = User::factory()->create([
            'username' => 'test_admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        $admin->assignRole('admin');
    }
}
