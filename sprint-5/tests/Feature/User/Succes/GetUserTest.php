<?php

namespace Tests\Feature\User\Succes;

use App\Models\User;
use App\Models\Course;
use Tests\ApiTestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GetUserTest extends ApiTestCase
{
    use RefreshDatabase;

    public function test_user_can_get_own_info()
    {
        $user = User::factory()->create();
        $courses = Course::factory()->count(2)->create();

        $user->courses()->attach($courses[0], ['progress' => 95, 'medal' => 'gold']);

        $user->assignRole('user');
        
        $token = $user->createToken('authToken')->accessToken;

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->getJson("/api/users/{$user->id}");

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'courses' => [
                        [
                            'id' => $courses[0]->id,
                            'title' => $courses[0]->title,
                            'progress' => 95,
                            'medal' => 'gold',
                        ],
                    ],
                ],
            ]);
    }

}
