<?php

namespace Tests\Feature\User\Succes;

use App\Models\User;
use App\Models\Course;
use Tests\ApiTestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GetAllUsersTest extends ApiTestCase
{
    use RefreshDatabase;

    public function test_get_all_users()
    {
        $this->withoutExceptionHandling();

        $admin = User::factory()->create();
        $user = User::factory()->create();

        $admin->assignRole('admin');
        $user->assignRole('user');


        $course = Course::factory()->create([
            'title' => 'Test Course',
            'description' => 'This is a test course',
            'content' => [
                [
                    'title' => 'Capítulo 1',
                    'description' => 'Descripción del capítulo 1',
                    'videos' => [
                        [
                            'title' => 'Test Video 1',
                            'description' => 'This is a test video 1',
                        ],
                    ],
                ],
            ],
        ]);

        $user->courses()->attach($course);


        $token = $admin->createToken('authToken')->accessToken;

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->getJson('/api/users');

        $response->assertStatus(200)
            ->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'username',
                    'email',
                    'courses' => [
                        '*' => [
                            'id',
                            'title',
                            'description',
                            'progress',
                            'medal',
                        ]
                    ]
                ]
            ]
        ]);
    
    }
}
