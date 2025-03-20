<?php

namespace Tests\Feature\Register\Success;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegisterUsersSuccessTest extends TestCase
{
    public function test_user_can_register()
    {
        $this->withoutExceptionHandling();

        $response = $this->postJson('/api/register', [
            'username' => 'example',
            'email' => 'example@gmail.com',
            'password' => '12345678!',
            'password_confirmation' => '12345678!',
        ]);

        $response->assertStatus(201)
            ->assertJsonStructure(['message', 'user']);
        
    }
}

