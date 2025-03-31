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
}
