<?php

namespace Tests\Feature\Progress\Success;

use App\Models\User;
use Tests\ApiTestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Course;

class CompletedChapterTest extends ApiTestCase
{
    use RefreshDatabase;

    public function test_complete_chapter()
    {
        $this->withoutExceptionHandling();

        $user = User::factory()->create();
        $user->assignRole('user');
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

        $response->assertStatus(200);
        $response->assertJson([
            'message' => 'Chapter completed successfully.',
        ]);
    }

    public function test_user_increase_progress_when_complete_chapter()
    {
        $this->withoutExceptionHandling();

        $user = User::factory()->create();
        $user->assignRole('user');
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

        $response->assertStatus(200);
        $response->assertJson([
            'message' => 'Chapter completed successfully.',
        ]);

        $this->assertDatabaseHas('course_user', [
            'user_id' => $user->id,
            'course_id' => $courseId,
            'progress' => 100,
        ]);
    }
}
