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
        //$this->withoutExceptionHandling();

        $user = User::factory()->create();
        $user->assignRole('user');
        $token = $user->createToken('authToken')->accessToken;

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->getJson('/api/users');
        
        $response->assertStatus(403);
    }

    public function test_admin_cannot_get_all_users_without_token()
    {
        //$this->withoutExceptionHandling();

        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $response = $this->getJson('/api/users');
        
        $response->assertStatus(401);
    }
}
