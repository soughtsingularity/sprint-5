<?php

namespace Tests\Feature\Register\Success;

use Tests\TestCase;
use App\Models\User;
use Tests\ApiTestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Constraints\HasInDatabase;

class LoginUsersSucccessTest extends ApiTestCase
{

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
}
