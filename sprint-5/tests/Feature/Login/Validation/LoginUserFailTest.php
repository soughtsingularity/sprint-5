<?php

namespace Tests\Feature\Login\Validation;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class LoginUserFailTest extends TestCase
{
    public function test_user_not_found()
    {
        $response = $this->postJson('/api/login', [
            'email' => 'noexistent@example.com',
            'password' => 'password123!',
        ]);

        $response->assertStatus(401)
            ->assertJson([
                'message' => 'Invalid credentials'
        ]);
    }

    public function user_login_with_invalid_credentuials($email, $password)
    {
        /**
         * @dataProvider invalidCredentialsProvider
         */

        $response = $this->postJson('/api/login', [
            'email' => $email,
            'password' => $password,
        ]);

        $response->assertStatus(401)
            ->assertJson([
                'message' => 'Invalid credentials'
        ]);
    }

    public static function invelidCredentialsProvider()
    {
        return [
            'wrong email' => ['wrong@example.com', 'password123!'],
            'wrong password' => ['example@example.com', 'wrongpassword'],
            'empty email' => ['', 'password123!'],
            'empty password' => ['example@example.com', ''],
            'null email' => [null, 'password123!'],
            'null password' => ['example@example.com', null],
        ];
    }

    public function test_user_exists_but_invalid_password()
    {
        User::factory()->create([
            'email' => 'example@example.com',
            'password' => bcrypt('correctPassword!'),
        ]);

        $response = $this->postJson('/api/login', [
            'email' => 'exampe@example.com',
            'password' => 'wrongpassword!',
        ]);

        $response->assertStatus(401)
            ->assertJson([
                'message' => 'Invalid credentials'
        ]);


    }




}
