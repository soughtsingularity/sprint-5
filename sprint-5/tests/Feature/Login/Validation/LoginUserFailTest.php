<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\ApiTestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use App\Models\User;


class LoginUserFailTest extends ApiTestCase
{
    #[DataProvider('invalidLoginCredentials')]
    public function test_user_cannot_login_with_invalid_credentials(array $data, string $errorField, string $errorMessage)
    {
        $user = User::factory()->create([
            'email' => 'duplicate@example.com',
            'password' => bcrypt('password123!'),
        ]);

        $response = $this->postJson('/api/login', $data);

        $response->assertStatus(401)
            ->assertJson([
                'message' => $errorMessage]);
    }

    public static function invalidLoginCredentials(): array
    {
        return [
            'Wrong email' => [
                [
                    'email' => 'wrong@example.com',
                    'password' => 'ValidPass123!',
                ],
                'email',
                'Invalid credentials',
            ],
            'Wrong password' => [
                [
                    'email' => 'valid@example.com',
                    'password' => 'WrongPassword!',
                ],
                'email',
                'Invalid credentials',
            ],
            'Both wrong' => [
                [
                    'email' => 'fake@example.com',
                    'password' => 'FakePassword!',
                ],
                'email',
                'Invalid credentials',
            ],
        ];
    }
    

}
