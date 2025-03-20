<?php

namespace Tests\Feature\Register\Success;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class RegisterUsersSuccessTest extends TestCase
{
    public function test_user_can_register()
    {

        $response = $this->postJson('/api/register', [
            'username' => 'example',
            'email' => 'example@gmail.com',
            'password' => '12345678!',
            'password_confirmation' => '12345678!',
        ]);

        $response->assertStatus(201)
            ->assertJsonStructure(['message', 'user']);
    }

    public function test_new_user_is_saved_in_database()
    {
        $userData = [
            'username' => 'example',
            'email' => 'example2@gmail.com',
            'password' => '12345678!',
            'password_confirmation' => '12345678!',
        ];

        $response = $this->postJson('/api/register', $userData);

        $response->assertStatus(201)
            ->assertJsonStructure(['message', 'user']);

            $this->assertDatabaseHas('users', [
                'email' => $userData['email'],
                'username' => $userData['username'],
            ]);

            $user = User::where('email', $userData['email'])->first();
            $this->assertTrue(app('hash')->check($userData['password'], $user->password));
    }

}

