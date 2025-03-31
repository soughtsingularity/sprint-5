<?php

namespace Tests\Feature\Course\Validation;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\ApiTestCase;
use App\Models\User;

class UpdateCourseFailTest extends ApiTestCase
{
    use RefreshDatabase;

    public function test_user_cannot_update_course()
    {
        //$this->withoutExceptionHandling();

        $user = User::factory()->create();
        $user->assignRole('user');

        $oldCourseData = [
            'title' => 'OldCourse',
            'description' => 'OldCourseDescription',
            'content' => [
                [
                    'title' => 'oldChapter',
                    'description' => 'oldDescription',
                    'videos' => [
                        [
                            'title' => 'oldVideo',
                            'description' => 'oldVideo1Description',
                            'url' => 'https://www.youtube.com/watch?v=video1'
                        ],
                    ]
                ],
            ]
        ];


        $course = $user->courses()->create($oldCourseData);

        $updatedCourseData = [
            'title' => 'UpdatedCourse',
            'description' => 'UpdatedCourseDescription',
            'content' => [
                [
                    'title' => 'UpdatedChapter',
                    'description' => 'UpdatedDescription',
                    'videos' => [
                        [
                            'title' => 'UpdatedVideo',
                            'description' => 'UpdatedVideo1Description',
                            'url' => 'https://www.youtube.com/watch?v=video1'
                        ],
                    ]
                ],
            ]
        ];

        $token = $user->createToken('authToken')->accessToken;

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->json('PUT', '/api/courses/' . $course->id, $updatedCourseData);

        $response->assertStatus(403);

    }

    public function test_admin_cannot_update_course_without_token()
    {
        //$this->withoutExceptionHandling();

        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $oldCourseData = [
            'title' => 'OldCourse',
            'description' => 'OldCourseDescription',
            'content' => [
                [
                    'title' => 'oldChapter',
                    'description' => 'oldDescription',
                    'videos' => [
                        [
                            'title' => 'oldVideo',
                            'description' => 'oldVideo1Description',
                            'url' => 'https://www.youtube.com/watch?v=video1'
                        ],
                    ]
                ],
            ]
        ];

        $course = $admin->courses()->create($oldCourseData);

        $updatedCourseData = [
            'title' => 'UpdatedCourse',
            'description' => 'UpdatedCourseDescription',
            'content' => [
                [
                    'title' => 'UpdatedChapter',
                    'description' => 'UpdatedDescription',
                    'videos' => [
                        [
                            'title' => 'UpdatedVideo',
                            'description' => 'UpdatedVideo1Description',
                            'url' => 'https://www.youtube.com/watch?v=video1'
                        ],
                    ]
                ],
            ]
        ];
        $response = $this->json('PUT', '/api/courses/' . $course->id, $updatedCourseData);
        $response->assertStatus(401)
            ->assertJson([
                'message' => 'Unauthenticated.',
            ]);
    }

    public function test_admin_cannot_update_course_with_invalid_token()
    {
        //$this->withoutExceptionHandling();

        $admin = User::factory()->create();
        $admin->assignRole('admin');
        $token = 'invalid_token';

        $oldCourseData = [
            'title' => 'OldCourse',
            'description' => 'OldCourseDescription',
            'content' => [
                [
                    'title' => 'oldChapter',
                    'description' => 'oldDescription',
                    'videos' => [
                        [
                            'title' => 'oldVideo',
                            'description' => 'oldVideo1Description',
                            'url' => 'https://www.youtube.com/watch?v=video1'
                        ],
                    ]
                ],
            ]
        ];

        $course = $admin->courses()->create($oldCourseData);

        $updatedCourseData = [
            'title' => 'UpdatedCourse',
            'description' => 'UpdatedCourseDescription',
            'content' => [
                [
                    'title' => 'UpdatedChapter',
                    'description' => 'UpdatedDescription',
                    'videos' => [
                        [
                            'title' => 'UpdatedVideo',
                            'description' => 'UpdatedVideo1Description',
                            'url' => 'https://www.youtube.com/watch?v=video1'
                        ],
                    ]
                ],
            ]
        ];
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->json('PUT', '/api/courses/' . $course->id, $updatedCourseData);
        
        $response->assertStatus(401)
            ->assertJson([
                'message' => 'Unauthenticated.',
            ]);
    }

}
