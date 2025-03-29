<?php

namespace Tests\Feature\Course\Success;

use App\Models\User;
use Tests\ApiTestCase;

class CreateCourseTest extends ApiTestCase
{

    public function test_admin_can_create_course(): void
    {

        $this->withoutExceptionHandling();

        $admin = User::where('email', 'admin@test.com')->first();
        $admin->assignRole('admin');
        $admin->hasPermissionTo('create-course');
        

        $courseData = [
            'title' => 'NewCourse',
            'description' => 'NewCourseDescription',
            'content' => [
                [
                    'title' => 'Capítulo 1',
                    'description' => 'Intro',
                    'videos' => [
                        [
                            'title' => 'Video1',
                            'description' => 'Video1Description',
                            'url' => 'https://www.youtube.com/watch?v=video1'
                        ],
                        [
                            'title' => 'Video2',
                            'description' => 'Video2Description',
                            'url' => 'https://www.youtube.com/watch?v=video2'
                        ]
                    ]
                ],
                [
                    'title' => 'Capítulo 2',
                    'description' => 'Segundo capítulo',
                    'videos' => [
                        [
                            'title' => 'Video3',
                            'description' => 'Video3Description',
                            'url' => 'https://www.youtube.com/watch?v=video3'
                        ]
                    ]
                ]
            ]
        ];

        $token = $admin->createToken('authToken')->accessToken;

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->postJson('/api/courses/', $courseData);

        $response->assertStatus(201)
                ->assertJsonFragment([
                    'title' => $courseData['title'],
                    'description' => $courseData['description'],
                ])
                ->assertJsonStructure([
                    'id',
                    'title',
                    'description',
                    'content' => [
                        ['title', 
                        'description', 
                        'videos' => [
                            ['title', 
                            'description', 
                            'url']
                        ]
                        ]
                    ],
                ]);
                    
                $this->assertDatabaseHas('courses', [
                    'title' => $courseData['title'],
                    'description' => $courseData['description']
                ]);
    }

}
