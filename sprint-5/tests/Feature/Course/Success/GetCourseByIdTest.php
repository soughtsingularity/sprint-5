<?php

namespace Tests\Feature\Course\Success;

use App\Models\User;
use App\Models\Course;
use Tests\ApiTestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GetCourseByIdTest extends ApiTestCase
{
    use RefreshDatabase;

    public function test_everyone_can_get_course_by_id()
    {
        $this->withoutExceptionHandling();
        
        $course = Course::create([
            'title' => 'Test Course',
            'description' => 'This is a test course',
            'content' => [
                [
                    'title' => 'Capítulo 1',
                    'description' => 'Intro',
                    'videos' => [
                        [
                            'title' => 'Video 1',
                            'description' => 'Desc video 1',
                            'url' => 'https://youtube.com/watch?v=abc123',
                        ]
                    ],
                ]
            ],
        ]);
        

        $response = $this->getJson('/api/courses/' . $course->id);

        $response->assertStatus(200)
        ->assertJsonStructure([
            'data' => [
                'id',
                'title',
                'description',
                'content' => [
                    [
                        'title',
                        'description',
                        'videos' => [
      
                      [
                                'title',
                                'description',
                                'url'
                            ]
                        ]
                    ]
                ],
                'users',
                'progress',
                'completed',
                'medal',
                'is_enrolled',
            ],
            'auth_user'
        ]);
    }

        public function test_authenticated_user_receives_personalized_course_data()
    {
        $user = User::factory()->create();
        $user->assignRole('user');
        $token = $user->createToken('TestToken')->accessToken;

        $course = Course::factory()->create([
            'content' => [
                [
                    'title' => 'Chapter 1',
                    'description' => 'Intro',
                    'videos' => [
                        ['title' => 'Video 1', 'description' => 'Desc', 'url' => 'https://youtube.com/watch?v=abc123']
                    ]
                ]
            ]
        ]);

        $user->courses()->attach($course->id, [
            'progress' => 100,
            'completed_chapters' => json_encode([0]),
            'medal' => 'gold',
        ]);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token
        ])->getJson('/api/courses/' . $course->id);

        $response->assertStatus(200)
                ->assertJson([
                    'data' => [
                        'is_enrolled' => true,
                        'progress' => 100,
                        'completed' => '[0]',
                        'medal' => 'gold',
                    ],
                    'auth_user' => [
                        'id' => $user->id,
                        'email' => $user->email,
                    ]
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

