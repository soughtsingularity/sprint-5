<?php

namespace Tests\Feature\Course\Validation;

use App\Models\User;
use Laravel\Passport\Passport;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\ApiTestCase;

class CreateCourseValidationTest extends ApiTestCase
{ 

    protected function setUp(): void
    {
        parent::setUp();
        $admin = User::where('email', 'admin@test.com')->first();
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

    #[DataProvider('invalidDescriptionProvider')]
    public function test_course_creation_failed_with_invalid_description($data, $errorField, $errorMessage)
    {
        $response = $this->postJson('/api/courses', $data);

        $response->assertStatus(422)
                ->assertJsonValidationErrors($errorField)
                ->assertJsonFragment([$errorMessage]);
    }

    #[DataProvider('invalidContentProvider')]
    public function test_course_creation_failed_with_invalid_content($data, $errorField, $errorMessage)
    {
        $response = $this->postJson('/api/courses', $data);

        $response->assertStatus(422)
                ->assertJsonValidationErrors($errorField)
                ->assertJsonFragment([$errorMessage]);
    }

    #[DataProvider('invalidContentTitleProvider')]
    public function test_course_creation_failed_with_invalid_content_title($data, $errorField, $errorMessage)
    {
        $response = $this->postJson('/api/courses', $data);

        $response->assertStatus(422)
                ->assertJsonValidationErrors($errorField)
                ->assertJsonFragment([$errorMessage]);
    }

    #[DataProvider('invalidContentDescriptionProvider')]
    public function test_course_creation_failed_with_invalid_content_description($data, $errorField, $errorMessage)
    {
        $response = $this->postJson('/api/courses', $data);

        $response->assertStatus(422)
                ->assertJsonValidationErrors($errorField)
                ->assertJsonFragment([$errorMessage]);
    }

    #[DataProvider('invalidVideoTitleProvider')]
    public function test_course_creation_failed_with_invalid_video_title($data, $errorField, $errorMessage)
    {
        $response = $this->postJson('/api/courses', $data);

        $response->assertStatus(422)
                ->assertJsonValidationErrors($errorField)
                ->assertJsonFragment([$errorMessage]);
    }

    #[DataProvider('invalidVideoDescriptionProvider')]
    public function test_course_creation_failed_with_invalid_video_description($data, $errorField, $errorMessage)
    {
        $response = $this->postJson('/api/courses', $data);

        $response->assertStatus(422)
                ->assertJsonValidationErrors($errorField)
                ->assertJsonFragment([$errorMessage]);
    }

    #[DataProvider('invalidVideoUrlProvider')]
    public function test_course_creation_failed_with_invalid_video_url($data, $errorField, $errorMessage)
    {
        $response = $this->postJson('/api/courses', $data);

        $response->assertStatus(422)
                ->assertJsonValidationErrors($errorField)
                ->assertJsonFragment([$errorMessage]);
    }

    public static function invalidTitleProvider(): array
    {
        return [
            'title is required' => [
                'data' => [
                    'title' => '',
                    'description' => 'exampleDescription',
                    'content' => [
                        [
                            'title' => 'Capítulo 1',
                            'description' => 'Intro',
                            'videos' => [
                                [
                                    'title' => 'Video 1',
                                    'description' => 'Video 1 Description',
                                    'url' => 'https://www.youtube.com/watch?v=123456',
                                ]
                            ]
                        ]
                    ]
                ],
                'errorField' => 'title',
                'errorMessage' => 'The title field is required.',
            ],
            'title must be a string' => [
                'data' => [
                    'title' => 123,
                    'description' => 'ExampleDescription',
                    'content' => [
                        [
                            'title' => 'Capítulo 1',
                            'description' => 'Intro',
                            'videos' => [
                                [
                                    'title' => 'Video 1',
                                    'description' => 'Video 1 Description',
                                    'url' => 'https://www.youtube.com/watch?v=123456',
                                ]
                            ]
                        ]
                    ]
                ],
                'errorField' => 'title',
                'errorMessage' => 'The title field must be a string.',
            ],
            'title must have at least 5 characters' => [
                'data' => [
                    'title' => '1234',
                    'description' => 'ExampleDescription',
                    'content' => [
                        [
                            'title' => 'Capítulo 1',
                            'description' => 'Intro',
                            'videos' => [
                                [
                                    'title' => 'Video 1',
                                    'description' => 'Video 1 Description',
                                    'url' => 'https://www.youtube.com/watch?v=123456',
                                ]
                            ]
                        ]
                    ]
                ],
                'errorField' => 'title',
                'errorMessage' => 'The title field must be at least 5 characters.',
            ],
            'title must not be greater than 50 characters' => [
                'data' => [
                    'title' => str_repeat('a', 51),
                    'description' => 'ExampleDescription',
                    'content' => [
                        [
                            'title' => 'Capítulo 1',
                            'description' => 'Intro',
                            'videos' => [
                                [
                                    'title' => 'Video 1',
                                    'description' => 'Video 1 Description',
                                    'url' => 'https://www.youtube.com/watch?v=123456',
                                ]
                            ]
                        ]
                    ]
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
                    'content' => [
                        [
                            'title' => 'Capítulo 1',
                            'description' => 'Intro',
                            'videos' => [
                                [
                                    'title' => 'Video 1',
                                    'description' => 'Video 1 Description',
                                    'url' => 'https://www.youtube.com/watch?v=123456',
                                ]
                            ]
                        ]
                    ]
                ],
                'errorField' => 'description',
                'errorMessage' => 'The description field is required.',
            ],
            'description must be a string' => [
                'data' => [
                    'title' => 'ExampleTitle',
                    'description' => 123,
                    'content' => [
                        [
                            'title' => 'Capítulo 1',
                            'description' => 'Intro',
                            'videos' => [
                                [
                                    'title' => 'Video 1',
                                    'description' => 'Video 1 Description',
                                    'url' => 'https://www.youtube.com/watch?v=123456',
                                ]
                            ]
                        ]
                    ]
                ],
                'errorField' => 'description',
                'errorMessage' => 'The description field must be a string.',
            ],
            'description must have at least 5 characters' => [
                'data' => [
                    'title' => 'ExampleTitle',
                    'description' => '1234',
                    'content' => [
                        [
                            'title' => 'Capítulo 1',
                            'description' => 'Intro',
                            'videos' => [
                                [
                                    'title' => 'Video 1',
                                    'description' => 'Video 1 Description',
                                    'url' => 'https://www.youtube.com/watch?v=123456',
                                ]
                            ]
                        ]
                    ]
                ],
                'errorField' => 'description',
                'errorMessage' => 'The description field must be at least 5 characters.',
            ],
            'description must not be greater than 255 characters' => [
                'data' => [
                    'title' => 'ExampleTitle',
                    'description' => str_repeat('a', 256),
                    'content' => [
                        [
                            'title' => 'Capítulo 1',
                            'description' => 'Intro',
                            'videos' => [
                                [
                                    'title' => 'Video 1',
                                    'description' => 'Video 1 Description',
                                    'url' => 'https://www.youtube.com/watch?v=123456',
                                ]
                            ]
                        ]
                    ]
                ],
                'errorField' => 'description',
                'errorMessage' => 'The description field must not be greater than 255 characters.',
            ],
        ];
    }
    

    public static function invalidContentProvider()
    {
        return [
            'content must be an array' => [
                'data' => [
                    'title' => '1234',
                    'description' => 'ExampleDescription',
                    'content' => [
                        'not an array'
                    ]
                ],
                'errorField' => 'title',
                'errorMessage' => 'The title field must be at least 5 characters.',
            ],
            'content must have at least 1 item' => [
                'data' => [
                    'title' => 'ExampleTitle',
                    'description' => 'ExampleDescription',
                    'content' => [],
                ],
                'errorField' => 'content',
                'errorMessage' => 'The content field is required.',
            ],
        ];
    }

    public static function invalidContentTitleProvider()
    {
        return [
            'content title is required' => [
                'data' => [
                    'title' => 'ExampleTitle',
                    'description' => 'ExampleDescription',
                    'content' => [[
                        'title' => '',
                        'description' => 'Intro',
                        'videos' => [[
                            'title' => 'Video 1',
                            'description' => 'Video 1 Description',
                            'url' => 'https://www.youtube.com/watch?v=123456',
                        ]]
                    ]],
                ],
                'errorField' => 'content.0.title',
                'errorMessage' => 'The content title field is required.',
            ],
            'content title must be a string' => [
                'data' => [
                    'title' => 'ExampleTitle',
                    'description' => 'ExampleDescription',
                    'content' => [[
                        'title' => 123,
                        'description' => 'Intro',
                        'videos' => [[
                            'title' => 'Video 1',
                            'description' => 'Video 1 Description',
                            'url' => 'https://www.youtube.com/watch?v=123456',
                        ]]
                    ]],
                ],
                'errorField' => 'content.0.title',
                'errorMessage' => 'The content title field must be a string.',
            ],
            'content title must have at least 5 characters' => [
                'data' => [
                    'title' => 'ExampleTitle',
                    'description' => 'ExampleDescription',
                    'content' => [[
                        'title' => '1234',
                        'description' => 'Intro',
                        'videos' => [[
                            'title' => 'Video 1',
                            'description' => 'Video 1 Description',
                            'url' => 'https://www.youtube.com/watch?v=123456',
                        ]]
                    ]],
                ],
                'errorField' => 'content.0.title',
                'errorMessage' => 'The content title field must be at least 5 characters.',
            ],
            'content title must not be greater than 50 characters' => [
                'data' => [
                    'title' => 'ExampleTitle',
                    'description' => 'ExampleDescription',
                    'content' => [[
                        'title' => str_repeat('a', 51),
                        'description' => 'Intro',
                        'videos' => [[
                            'title' => 'Video 1',
                            'description' => 'Video 1 Description',
                            'url' => 'https://www.youtube.com/watch?v=123456',
                        ]]
                    ]],
                ],
                'errorField' => 'content.0.title',
                'errorMessage' => 'The content title field must not be greater than 50 characters.',
            ],
        ];
    }

    public static function invalidContentDescriptionProvider()
    {
        return [
            'content description is required' => [
                'data' => [
                    'title' => 'ExampleTitle',
                    'description' => 'ExampleDescription',
                    'content' => [[
                        'title' => 'Capítulo 1',
                        'description' => '',
                        'videos' => [[
                            'title' => 'Video 1',
                            'description' => 'Video 1 Description',
                            'url' => 'https://www.youtube.com/watch?v=123456',
                        ]]
                    ]],
                ],
                'errorField' => 'content.0.description',
                'errorMessage' => 'The content description field is required.',
            ],
            'content description must be a string' => [
                'data' => [
                    'title' => 'ExampleTitle',
                    'description' => 'ExampleDescription',
                    'content' => [[
                        'title' => 'Capítulo 1',
                        'description' => 123,
                        'videos' => [[
                            'title' => 'Video 1',
                            'description' => '',
                            'url' => '',
                        ]]
                    ]],
                ],
                'errorField' => 'content.0.description',
                'errorMessage' => 'The content description field must be a string.',
            ],
            'content description must have at least 5 characters' => [
                'data' => [
                    'title' => 'ExampleTitle',
                    'description' => 'ExampleDescription',
                    'content' => [[
                        'title' => 'Capítulo 1',
                        'description' => '1234',
                        'videos' => [[
                            'title' => 'Video 1',
                            'description' => '',
                            'url' => '',
                        ]]
                    ]],
                ],
                'errorField' => 'content.0.description',
                'errorMessage' => 'The content description field must be at least 5 characters.',
            ],
            'content description must not be greater than 255 characters' => [
                'data' => [
                    'title' => 'ExampleTitle',
                    'description' => 'ExampleDescription',
                    'content' => [[
                        'title' => 'Capítulo 1',
                        'description' => str_repeat('a', 256),
                        'videos' => [[
                            'title' => 'Video 1',
                            'description' => '',
                            'url' => '',
                        ]]
                    ]],
                ],
                'errorField' => 'content.0.description',
                'errorMessage' => 'The content description field must not be greater than 255 characters.',
            ],
        ];
    }

    public static function invalidVideoTitleProvider()
    {
        return [
            'title is required' => [
                'data' => [
                    'title' => 'ExampleTitle',
                    'description' => 'ExampleDescription',
                    'content' => [[
                        'title' => 'Capítulo 1',
                        'description' => 'Intro',
                        'videos' => [[
                            'title' => '',
                            'description' => 'Video 1 Description',
                            'url' => 'https://www.youtube.com/watch?v=123456',
                        ]]
                    ]],
                ],
                'errorField' => 'content.0.videos.0.title',
                'errorMessage' => 'The Video title field is required.',
            ],
            'title must be a string' => [
                'data' => [
                    'title' => 'ExampleTitle',
                    'description' => 'ExampleDescription',
                    'content' => [[
                        'title' => 'Capítulo 1',
                        'description' => 'Intro',
                        'videos' => [[
                            'title' => 123,
                            'description' => 'Video 1 Description',
                            'url' => 'https://www.youtube.com/watch?v=123456',
                        ]]
                    ]],
                ],
                'errorField' => 'content.0.videos.0.title',
                'errorMessage' => 'The Video title field must be a string.',
            ],
            'Video title must have at least 5 characters' => [
                'data' => [
                    'title' => 'ExampleTitle',
                    'description' => 'ExampleDescription',
                    'content' => [[
                        'title' => 'Capítulo 1',
                        'description' => 'Intro',
                        'videos' => [[
                            'title' => 'abc',
                            'description' => 'Video 1 Description',
                            'url' => 'https://www.youtube.com/watch?v=123456',
                        ]]
                    ]],
                ],
                'errorField' => 'content.0.videos.0.title',
                'errorMessage' => 'The Video title field must be at least 5 characters.',
            ],
            'title must not be greater than 50 characters' => [
                'data' => [
                    'title' => 'ExampleTitle',
                    'description' => 'ExampleDescription',
                    'content' => [[
                        'title' => 'Capítulo 1',
                        'description' => 'Intro',
                        'videos' => [[
                            'title' => str_repeat('a', 51),
                            'description' => 'Video 1 Description',
                            'url' => 'https://www.youtube.com/watch?v=123456',
                        ]]
                    ]],
                ],
                'errorField' => 'content.0.videos.0.title',
                'errorMessage' => 'The Video title field must not be greater than 50 characters.',
            ],
        ];
    }
    

    public static function invalidVideoDescriptionProvider()
    {
        return [
            'description is required' => [
                'data' => [
                    'title' => 'ExampleTitle',
                    'description' => 'ExampleDescription',
                    'content' => [[
                        'title' => 'Capítulo 1',
                        'description' => 'Intro',
                        'videos' => [[
                            'title' => 'Video 1',
                            'description' => '',
                            'url' => 'https://www.youtube.com/watch?v=123456',
                        ]]
                    ]],
                ],
                'errorField' => 'content.0.videos.0.description',
                'errorMessage' => 'The Video description field is required.',
            ],
            'description must be a string' => [
                'data' => [
                    'title' => 'ExampleTitle',
                    'description' => 'ExampleDescription',
                    'content' => [[
                        'title' => 'Capítulo 1',
                        'description' => 'Intro',
                        'videos' => [[
                            'title' => 'Video 1',
                            'description' => 123,
                            'url' => 'https://www.youtube.com/watch?v=123456',
                        ]]
                    ]],
                ],
                'errorField' => 'content.0.videos.0.description',
                'errorMessage' => 'The Video description field must be a string.',
            ],
            'description must have at least 5 characters' => [
                'data' => [
                    'title' => 'ExampleTitle',
                    'description' => 'ExampleDescription',
                    'content' => [[
                        'title' => 'Capítulo 1',
                        'description' => 'Intro',
                        'videos' => [[
                            'title' => 'Video 1',
                            'description' => 'abc',
                            'url' => 'https://www.youtube.com/watch?v=123456',
                        ]]
                    ]],
                ],
                'errorField' => 'content.0.videos.0.description',
                'errorMessage' => 'The Video description field must be at least 5 characters.',
            ],
            'description must not be greater than 255 characters' => [
                'data' => [
                    'title' => 'ExampleTitle',
                    'description' => 'ExampleDescription',
                    'content' => [[
                        'title' => 'Capítulo 1',
                        'description' => 'Intro',
                        'videos' => [[
                            'title' => 'Video 1',
                            'description' => str_repeat('a', 256),
                            'url' => 'https://www.youtube.com/watch?v=123456',
                        ]]
                    ]],
                ],
                'errorField' => 'content.0.videos.0.description',
                'errorMessage' => 'The Video description field must not be greater than 255 characters.',
            ],
        ];
    }
    

    public static function invalidVideoUrlProvider()
    {
        return [
            'url is required' => [
                'data' => [
                    'title' => 'ExampleTitle',
                    'description' => 'ExampleDescription',
                    'content' => [[
                        'title' => 'Capítulo 1',
                        'description' => 'Intro',
                        'videos' => [[
                            'title' => 'Video 1',
                            'description' => 'Descripción del video',
                            'url' => '', 
                        ]]
                    ]],
                ],
                'errorField' => 'content.0.videos.0.url',
                'errorMessage' => 'The Video url field is required.',
            ],
            'url format is invalid' => [
                'data' => [
                    'title' => 'ExampleTitle',
                    'description' => 'ExampleDescription',
                    'content' => [[
                        'title' => 'Capítulo 1',
                        'description' => 'Intro',
                        'videos' => [[
                            'title' => 'Video 1',
                            'description' => 'Descripción del video',
                            'url' => 'not-a-valid-url', 
                        ]]
                    ]],
                ],
                'errorField' => 'content.0.videos.0.url',
                'errorMessage' => 'The Video url format is invalid.',
                ],
            ];
        }
        
    }