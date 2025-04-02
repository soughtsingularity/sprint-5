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

        $user2 = User::factory()->create([
            'username' => 'test_user2',
            'email' => 'user2@test.com',
            'password' => bcrypt('password123!'),
            'role' => 'user',
        ]);

        $user2->assignRole('user');


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

        $course2 = Course::factory()->create([
            'title' => 'Test Course 2',
            'description' => 'This is a test course 2',
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
                    ],
                [
                    'title' => 'Capítulo 2',
                    'description' => 'Descripción del capítulo 2',
                    'videos' => [
                        [
                            'title' => 'Test Video 3',
                            'description' => 'This is a test video 3',
                            'url' => 'https://www.youtube.com/watch?v=789012',
                        ],
                        [
                            'title' => 'Test Video 4',
                            'description' => 'This is a test video 4',
                            'url' => 'https://www.youtube.com/watch?v=210987',
                        ],
                    ]
                    ],
                [
                    'title' => 'Capítulo 3',
                    'description' => 'Descripción del capítulo 3',
                    'videos' => [
                        [
                            'title' => 'Test Video 5',
                            'description' => 'This is a test video 5',
                            'url' => 'https://www.youtube.com/watch?v=345678',
                        ],
                        [
                            'title' => 'Test Video 6',
                            'description' => 'This is a test video 6',
                            'url' => 'https://www.youtube.com/watch?v=876543',
                        ],
                    ]
                ]
            ]
        ]);

        $user->courses()->attach($course->id, [
            'progress' => 60,
            'medal' => 'silver',
        ]);
        
        $user2->courses()->attach($course2->id, [
            'progress' => 95,
            'medal' => 'gold',
        ]);
        
    }
}
