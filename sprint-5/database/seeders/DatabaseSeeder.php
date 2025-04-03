<?php

namespace Database\Seeders;

use App\Models\User;
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
            'username' => 'UserTest',
            'email' => 'user@test.com',
            'password' => bcrypt('password123!'),
            'role' => 'user',
        ]);

        $user->assignRole('user');

        $user2 = User::factory()->create([
            'username' => 'UserTest2',
            'email' => 'user2@test.com',
            'password' => bcrypt('password123!'),
            'role' => 'user',
        ]);

        $user2->assignRole('user');

        $admin = User::factory()->create([
            'username' => 'Admin',
            'email' => 'admin@test.com',
            'password' => bcrypt('password123!'),
            'role' => 'admin',
        ]);

        $admin->assignRole('admin');

        $course = Course::factory()->create([
            'title' => 'Basics',
            'description' => 'This is a test course that cover the basics of web development',
            'content' => [
                [
                    'title' => 'Chapter 1: How works internet',
                    'description' => 'THe chapter covers the basics of internet',
                    'videos' => [
                        [
                            'title' => 'How works internet',
                            'description' => 'THe video cover the basics of internet',
                            'url' => 'https://www.youtube.com/embed/rw41W8crZ_Y',
                        ],
                        [
                            'title' => 'What a server is',
                            'description' => 'THe video cover the basics of server',
                            'url' => 'https://www.youtube.com/embed/AsJWIxh84No',
                        ],
                    ]
                ]
            ]
        ]);

        $course2 = Course::factory()->create([
            'title' => 'Python',
            'description' => 'This is a test course that cover the basics of python',
            'content' => [
                [
                    'title' => 'Chapter 1: Python Basics',
                    'description' => 'THe chapter covers the basics of python',
                    'videos' => [
                        [
                            'title' => 'Python for beginners',
                            'description' => 'This video covers the basics of python',
                            'url' => 'https://www.youtube.com/embed/kqtD5dpn9C8',
                        ],
                        [
                            'title' => 'Python full course for beginners',
                            'description' => 'This video covers the basics of python',
                            'url' => 'https://www.youtube.com/embed/K5KVEU3aaeQ',
                        ],
                    ]
                ],
                [
                    'title' => 'Capítulo 2: Python Logic with games',
                    'description' => 'The chapter covers the basics of python logic with games',
                    'videos' => [
                        [
                            'title' => 'Snake game with Python',
                            'description' => 'In this video we will learn how to create a snake game with python',
                            'url' => 'https://www.youtube.com/embed/bfRwxS5d0SI',
                        ],
                        [
                            'title' => 'Tetris in Python with Pygame',
                            'description' => 'In this video we will learn how to create a tetris game with python',
                            'url' => 'https://www.youtube.com/embed/nF_crEtmpBo',
                        ],
                    ]
                ],
                [
                    'title' => 'Chapter 3: Python for web development',
                    'description' => 'The chapter covers the basics of web development with python',
                    'videos' => [
                        [
                            'title' => 'This video cover python development since the basics to web development',
                            'description' => 'In this video we will learn how to create a web application with python',
                            'url' => 'https://www.youtube.com/embed/Kp4Mvapo5kc',
                        ],
                    ]
                ]
            ]
        ]);

        $user->courses()->attach($course->id, [
            'progress' => 100,
            'medal' => 'gold',
        ]);
        
        $user2->courses()->attach($course2->id, [
            'progress' => 0,
            'medal' => 'none',
        ]);
    }
}
