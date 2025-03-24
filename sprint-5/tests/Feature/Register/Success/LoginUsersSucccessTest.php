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
            'email' => 'example@example.com',
            'password' => bcrypt('password123!'),
        ]);

        $response = $this->postJson('/api/login', [
            'email' => 'example@example.com',
            'password' => 'password123!',
        ]);

        $response->assertStatus(200);
    }
}
