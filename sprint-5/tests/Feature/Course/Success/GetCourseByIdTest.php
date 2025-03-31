<?php

namespace Tests\Feature\Course\Success;

use App\Models\Course;
use Tests\ApiTestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GetCourseByIdTest extends ApiTestCase
{
    use RefreshDatabase;

    public function test_everyone_can_get_course_by_id()
    {
        $this->withoutExceptionHandling();
        
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

        $response = $this->getJson('/api/courses/' . $course->id);

        $response->assertStatus(200)
        ->assertJson([
            'data' => [
                'id' => $course->id,
                'title' => 'Test Course',
                'description' => 'This is a test course',
                'content' => json_decode($course->content, true),
            ],
        ]);
    
    }

    public function test_course_not_found()
    {
        //$this->withoutExceptionHandling();
    
        $course = Course::factory()->create();
        
        $response = $this->getJson('/api/courses/' . $course->id + 1);
    
        $response->assertStatus(404);
    }
    
}

