<?php

namespace Tests\Feature\Course\Success;

use App\Models\User;
use Tests\ApiTestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UpdateCourseTest extends ApiTestCase
{
    use RefreshDatabase;

    public function test_admin_can_update_a_course()
    {
        $this->withoutExceptionHandling();

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

        $token = $admin->createToken('authToken')->accessToken;

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->putJson('/api/courses/' . $course->id, $updatedCourseData);

        $response->assertStatus(200)
        ->assertJson([
            'id' => $course->id,
            'title' => $updatedCourseData['title'],
            'description' => $updatedCourseData['description'],
            'content' => $updatedCourseData['content'],
        ]);



    }
}
