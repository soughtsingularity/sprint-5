<?php

namespace Tests\Feature\Progress\Validation;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\ApiTestCase;
use App\Models\User;
use App\Models\Course;

class CompletedChapterFailTest extends ApiTestCase
{
    use RefreshDatabase;

    public function test_complete_chapter_without_token()
    {
        //$this->withoutExceptionHandling();

        $user = User::factory()->create();
        $user->assignRole('user');

        $course = Course::factory()->create([
            'title' => 'Test Course',
            'description' => 'This is a test course',
            'content' => json_encode([
                [
                    'title' => 'Capítulo 1',
                    'description' => 'Intro',
                    'videos' => [
                        [
                            'title' => 'Video 1',
                            'description' => 'Desc video 1',
                            'url' => 'https://youtube.com/watch?v=abc123'
                        ]
                    ]
                ]
            ]),
        ]);

        $user->courses()->attach($course->id);

        $courseId = $course->id;
        $chapterIndex = 0;

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ',
        ])->postJson("/api/courses/{$courseId}/chapters/{$chapterIndex}/complete");

        $response->assertStatus(401);
        $response->assertJson([
            'message' => 'Unauthenticated.',
        ]);
    }

    public function test_complete_chapter_with_invalid_token()
    {
        //$this->withoutExceptionHandling();

        $user = User::factory()->create();
        $user->assignRole('user');
        $token = 'Invalid token';

        $course = Course::factory()->create([
            'title' => 'Test Course',
            'description' => 'This is a test course',
            'content' => json_encode([
                [
                    'title' => 'Capítulo 1',
                    'description' => 'Intro',
                    'videos' => [
                        [
                            'title' => 'Video 1',
                            'description' => 'Desc video 1',
                            'url' => 'https://youtube.com/watch?v=abc123'
                        ]
                    ]
                ]
            ]),
        ]);

        $user->courses()->attach($course->id);

        $courseId = $course->id;
        $chapterIndex = 0;

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->postJson("/api/courses/{$courseId}/chapters/{$chapterIndex}/complete");

        $response->assertStatus(401);
        $response->assertJson([
            'message' => 'Unauthenticated.',
        ]);
    }

    public function test_complete_chapter_without_user_role()
    {
        //$this->withoutExceptionHandling();

        $user = User::factory()->create();
        $token = $user->createToken('TestToken')->accessToken;

        $course = Course::factory()->create([
            'title' => 'Test Course',
            'description' => 'This is a test course',
            'content' => json_encode([
                [
                    'title' => 'Capítulo 1',
                    'description' => 'Intro',
                    'videos' => [
                        [
                            'title' => 'Video 1',
                            'description' => 'Desc video 1',
                            'url' => 'https://youtube.com/watch?v=abc123'
                        ]
                    ]
                ]
            ]),
        ]);

        $user->courses()->attach($course->id);

        $courseId = $course->id;
        $chapterIndex = 0;

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->postJson("/api/courses/{$courseId}/chapters/{$chapterIndex}/complete");

        $response->assertStatus(403);
    }
}
