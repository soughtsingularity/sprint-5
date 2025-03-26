<?php

namespace Tests\Feature\Course\Success;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use Laravel\Passport\Passport;
use Tests\ApiTestCase;

class CreateCourseTest extends ApiTestCase
{

    public function test_admin_can_create_course(): void
    {

        $this->withoutExceptionHandling();

        $admin = User::where('email', 'admin@gmail.com')->first();
        Passport::actingAs($admin);
        $admin->assignRole('admin');

        $courseData = [
            'title' => 'NewCoourse',
            'description' => 'NewCourseDescription',
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

        ];

        $response = $this->postJson('/api/courses', $courseData);

        $response->assertStatus(201)
                ->assertJsonFragment([
                    'title' => $courseData['title'],
                    'description' => $courseData['description'],
                ])
                ->assertJsonStructure([
                    'id',
                    'title',
                    'description',
                    'videos' => [
                        'title', 'description', 'url'
                    ]
                ]);
    }

}
