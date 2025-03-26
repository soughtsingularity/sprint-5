<?php

namespace Tests\Feature\Course\Validation;

use Tests\TestCase;
use App\Models\User;
use Laravel\Passport\Passport;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\ApiTestCase;

class CreateCourseValidationTest extends ApiTestCase
{ 

    protected function setUp(): void
    {
        parent::setUp();
        $admin = User::where('email', 'admin@gmail.com')->first();
        Passport::actingAs($admin);
    }
    
    #[DataProvider('invalidTitleProvider')]
    public function test_course_creation_fails_with_invalid_title($data, $errorField, $errorMessage)
    {
        $response = $this->postJson('/api/courses', $data);

        $response->assertStatus(422)
                ->assertJsonValidationErrors($errorField)
                ->assertJsonFragment([$errorMessage]);
    }

    // #[DataProvider('invalidDescriptionProvider')]
    // public function test_course_creation_failed_with_invalid_description($data, $errorField, $errorMessage)
    // {
    //     $response = $this->postJson('/api/courses', $data);

    //     $response->assertStatus(422)
    //             ->assertJsonValidationErrors($errorField)
    //             ->assertJsonFragment([$errorMessage]);

    // }

    // #[DataProvider('invalidVideosProvider')]
    // public function test_course_creation_failed_with_invalid_videos($data, $errorField, $errorMessage)
    // {
    //     $response = $this->postJson('/api/courses', $data);

    //     $response->assertStatus(422)
    //             ->assertJsonValidationErrors($errorField)
    //             ->assertJsonFragment([$errorMessage]);
    // }

    // #[DataProvider('invalidVideoTitleProvider')]
    // public function test_course_creation_failed_with_invalid_video_title($data, $errorField, $errorMessage)
    // {
    //     $response = $this->postJson('/api/courses', $data);

    //     $response->assertStatus(422)
    //             ->assertJsonValidationErrors($errorField)
    //             ->assertJsonFragment([$errorMessage]);
    // }

    // #[DataProvider('invalidVideoDescriptionProvider')]
    // public function test_course_creation_failed_with_invalid_video_description($data, $errorField, $errorMessage)
    // {
    //     $response = $this->postJson('/api/courses', $data);

    //     $response->assertStatus(422)
    //             ->assertJsonValidationErrors($errorField)
    //             ->assertJsonFragment([$errorMessage]);
    // }

    // #[DataProvider('invalidUsernameProvider')]
    // public function test_course_creation_failed_with_invalid_video_url($data, $errorField, $errorMessage)
    // {
    //     $response = $this->postJson('/api/courses', $data);

    //     $response->assertStatus(422)
    //             ->assertJsonValidationErrors($errorField)
    //             ->assertJsonFragment([$errorMessage]);
    // }

    public static function invalidTitleProvider(): array
    {
        return [
            
            'title is required' => [
                'data' => [
                    'title' => '',
                    'description' => 'exampleDescription',
                    'videos' => [[
                        'title' => 'Video 1',
                        'description' => 'Video 1 Description',
                        'url' => 'https://www.youtube.com/watch?v=123456',
                    ]],
                ],
                'errorField' => 'title',
                'errorMessage' => 'The title field is required.',
            ],
            'title must be a string ' => [
                'data' => [
                    'title' => 123,
                    'description' => 'ExampleDescription',
                    'videos' => [[
                        'title' => 'Video 1',
                        'description' => 'Video 1 Description',
                        'url' => 'https://www.youtube.com/watch?v=123456',
                    ]],
                ],
                'errorField' => 'title',
                'errorMessage' => 'The title field must be a string.',
            ],
            'title must have at leat 5 characters' => [
                'data' => [
                    'title' => '1234',
                    'description' => 'ExampleDescription',
                    'videos' => [[
                        'title' => 'Video 1',
                        'description' => 'Video 1 Description',
                        'url' => 'https://www.youtube.com/watch?v=123456',
                    ]],
                ],
                'errorField' => 'title',
                'errorMessage' => 'The title field must be at least 5 characters.',
            ],
            'title must not be greater than 50 characters' => [
                'data' => [
                    'title' => str_repeat('a', 51),
                    'description' => 'ExampleDescription',
                    'videos' => [[
                        'title' => 'Video 1',
                        'description' => 'Video 1 Description',
                        'url' => 'https://www.youtube.com/watch?v=123456',
                    ]],
                ],
                'errorField' => 'title',
                'errorMessage' => 'The title field must not be greater than 50 characters.',
            ],
        ];
    }

     public static function invalidDescriptionProvider()
     {
        return [
            
            'description is required' => [
                'data' => [
                    'title' => 'ExampleTitle',
                    'description' => '',
                    'videos' => [[
                        'title' => 'Video 1',
                        'description' => 'Video 1 Description',
                        'url' => 'https://www.youtube.com/watch?v=123456',
                    ]],
                    ],
                    'errorField' => 'description',
                    'errorMessage' => 'The description field is required.',
                ],
                'description must be a string' => [
                    'data' => [
                        'title' => 'ExampleTitle',
                        'description' => 123,
                        'videos' => [[
                            'title' => 'Video 1',
                            'description' => 'Video 1 Description',
                            'url' => 'https://www.youtube.com/watch?v=123456',
                        ]],
                    ],
                    'errorField' => 'description',
                    'errorMessage' => 'The description field must be a string.',
                ],
                'description must have at least 5 characters' => [
                    'data' => [
                        'title' => 'ExampleTitle',
                        'description' => '1234',
                        'videos' => [[
                            'title' => 'Video 1',
                            'description' => 'Video 1 Description',
                            'url' => 'https://www.youtube.com/watch?v=123456',
                        ]],
                    ],
                    'errorField' => 'description',
                    'errorMessage' => 'The description field must be at least 5 characters.',
                ],
                'description must not be greater than 255 characters' => [
                    'data' => [
                        'title' => 'ExampleTitle',
                        'description' => str_repeat('a', 256),
                        'videos' => [[
                            'title' => 'Video 1',
                            'description' => 'Video 1 Description',
                            'url' => 'https://www.youtube.com/watch?v=123456',
                        ]],
                    ],
                    'errorField' => 'description',
                    'errorMessage' => 'The description field must not be greater than 255 characters.',
                ],

            ];
     }

    public static function invalidVideosProvider()
    {
        return [
            
            'videos is required' => [
                'data' => [
                    'title' => 'ExampleTitle',
                    'description' => 'ExampleDescription',
                    'videos' => [],
                ],
                'errorField' => 'videos',
                'errorMessage' => 'The videos field must have at least 1 item.',
            ],
            'videos must be an array' => [
                'data' => [
                    'title' => 'ExampleTitle',
                    'description' => 'ExampleDescription',
                    'videos' => 'invalid',
                ],
                'errorField' => 'videos',
                'errorMessage' => 'The videos field must be an array.',
            ],
            'videos must have at least 1 item' => [
                'data' => [
                    'title' => 'ExampleTitle',
                    'description' => 'ExampleDescription',
                    'videos' => [],
                ],
                'errorField' => 'videos',
                'errorMessage' => 'The videos field must have at least 1 item.',
            ],
        ];
        
    }

    // public static function invalidVideoTitleProvider()
    // {
        
    // }

    // public static function invalidVideoDescriptionProvider()
    // {
        
    // }

    // public static function invalidVideoUrlProvider()
    // {
        
    // }
}