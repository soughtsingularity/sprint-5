<?php

namespace Tests\Feature\User\Validation;

use App\Models\User;
use Tests\ApiTestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GetAllUsersFailTest extends ApiTestCase
{
    use RefreshDatabase;

    public function test_user_cannote_get_all_users()
    {
        $this->withoutExceptionHandling();

        $user = User::factory()->create();
        $user->assignRole('user');
        $token = $user->createToken('authToken')->accessToken;

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->getJson('/api/users');
        
        $response->assertStatus(403);
    }
}
