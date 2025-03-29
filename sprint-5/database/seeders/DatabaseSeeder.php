<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\Course;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(RolesAndPermissionsSeeder::class);
        $this->call(PassportSeeder::class);

        $user = User::factory()->create([
            'username' => 'test_user',
            'email' => 'user@test.com',
            'password' => bcrypt('password123!'),
            'role' => 'user',
        ]);

        $user->assignRole('user');


        $admin = User::factory()->create([
            'username' => 'test_admin',
            'email' => 'admin@test.com',
            'password' => bcrypt('password123!'),
            'role' => 'admin',
        ]);

        $admin->assignRole('admin');

        $course = Course::factory()->create([
            'title' => 'Test Course',
            'description' => 'This is a test course',
            'content' => [
                [
                    'title' => 'Capítulo 1',
                    'description' => 'Descripción del capítulo 1',
                    'videos' => [
                        [
                            'title' => 'Test Video 1',
                            'description' => 'This is a test video 1',
                            'url' => 'https://www.youtube.com/watch?v=123456',
                        ],
                        [
                            'title' => 'Test Video 2',
                            'description' => 'This is a test video 2',
                            'url' => 'https://www.youtube.com/watch?v=654321',
                        ],
                    ]
                ]
            ]
        ]);
        
    }
}
