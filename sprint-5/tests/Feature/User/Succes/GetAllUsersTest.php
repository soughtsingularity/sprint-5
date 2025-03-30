<?php

namespace Tests\Feature\User\Succes;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\ApiTestCase;

class GetAllUsersTest extends ApiTestCase
{
    use RefreshDatabase;

    public function test_get_all_users()
    {
        $this->withoutExceptionHandling();

        $admin = User::factory()->create(['role' => 'admin']);
        $user1 = User::factory()->create(['role' => 'user']);
        $user2 = User::factory()->create(['role' => 'user']);
        $user3 = User::factory()->create(['role' => 'user']);

        $token = $admin->createToken('authToken')->accessToken;

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->getJson('/api/users');

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    [
                        'id' => $user1->id,
                        'name' => $user1->name,
                        'email' => $user1->email,
                    ],
                    [
                        'id' => $user2->id,
                        'name' => $user2->name,
                        'email' => $user2->email,
                    ],
                    [
                        'id' => $user3->id,
                        'name' => $user3->name,
                        'email' => $user3->email,
                    ],
                ],
            ]);
    }
}
