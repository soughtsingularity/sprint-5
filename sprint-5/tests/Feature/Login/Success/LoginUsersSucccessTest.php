<?php

namespace Tests\Feature\Register\Success;

use App\Models\User;
use Tests\ApiTestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoginUsersSucccessTest extends ApiTestCase
{
    use RefreshDatabase;

    public function test_user_can_login()
    {
        $this->withoutExceptionHandling();

        User::factory()->create([
            'email' => 'example@example.com',
            'password' => bcrypt('password123!'),
        ]);

        $response = $this->postJson('/api/login', [
            'email' => 'example@example.com',
            'password' => 'password123!',
        ]);

        $response->assertStatus(200);
    }

    public function test_user_can_login_and_receive_token()
    {
        $this->withoutExceptionHandling();

        User::factory()->create([
            'email' => 'example@example.com',
            'password' => bcrypt('password123!'),
        ]);

        $response = $this->postJson('/api/login', [
            'email' => 'example@example.com',
            'password' => 'password123!',
        ]);

        $response->assertStatus(200)
                ->assertJsonStructure([
                'message',
                'user',
                'token',
        ]);
    }

    public function test_user_can_login_with_token_and_be_Saved_in_database()
    {
        $this->withoutExceptionHandling();

        $user = User::factory()->create([
            'email' => 'example@example.com',
            'password' => bcrypt('password123!'),
        ]);

        $response = $this->postJson('/api/login', [
            'email' => 'example@example.com',
            'password' => 'password123!',
        ]);

        $response->assertStatus(200)
                ->assertJsonStructure([
                'message',
                'user',
                'token',
        ]);

        $this->assertDatabaseHas('users', [
            'email' => 'example@example.com'
        ]);
    }

    public function test_user_token_stored_in_database()
    {
        $this->withoutExceptionHandling();

        $user = User::factory()->create([
            'email' => 'example@example.com',
            'password' => bcrypt('password123!'),
        ]);

        $response = $this->postJson('/api/login', [
            'email' => 'example@example.com',
            'password' => 'password123!',
        ]);

        $this->assertDatabaseHas('oauth_access_tokens', [
            'user_id' => $user->id,
            'name' => 'authToken',
            'revoked' => 0 
        ]);
    }
}
