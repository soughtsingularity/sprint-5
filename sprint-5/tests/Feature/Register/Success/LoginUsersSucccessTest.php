<?php

namespace Tests\Feature\Register\Success;

use Tests\TestCase;
use App\Models\User;
use Tests\ApiTestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoginUsersSucccessTest extends ApiTestCase
{

    public function test_user_can_login()
    {
        $this->withoutExceptionHandling();

        $user = User::factory()->create([
            'email' => 'example@login.com',
            'password' => bcrypt('password123!'),
        ]);

        $this->assertDatabaseHas('users', [
            'email' => 'example@login.com',
        ]);

        $response = $this->postJson('/api/login', [
            'email' => 'example@login.com',
            'password' => 'password123!',
        ]);

        $response->assertStatus(200)
        ->assertJsonStructure([
            'message',
            'user' => ['id', 'username', 'email'],
            'token',
        ])
        ->assertJson([
            'message' => 'Login successful',
            'user' => [
                'id' => $user->id,
                'username' => $user->username,
                'email' => $user->email,
            ],
        ]);
    }


}
