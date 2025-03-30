<?php

namespace Tests\Feature\User\Validation;

use Tests\ApiTestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GetUserFailTest extends ApiTestCase
{
    use RefreshDatabase;

    public function test_user_cannot_get_other_user_info()
    {
        $this->withoutExceptionHandling();

        $user = User::factory()->create();
        $otherUser = User::factory()->create();

        $user->assignRole('user');
        $otherUser->assignRole('user');

        $token = $user->createToken('authToken')->accessToken;

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->getJson("/api/users/{$otherUser->id}");

        $response->assertStatus(403)
            ->assertJson([
                'message' => 'Forbidden',
            ]);
    }
}
