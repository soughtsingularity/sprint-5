<?php

namespace Tests\Feature\Feature\Register\Validation;

use Tests\TestCase;
use Tests\ApiTestCase;
use Laravel\Passport\ClientRepository;
use Illuminate\Foundation\Testing\WithFaker;
use Database\Seeders\RolesAndPermissionsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use PHPUnit\Framework\Attributes\DataProvider;

class RegisterUserFailTest extends ApiTestCase
{
    #[DataProvider('invalidUsernameProvider')]
    public function test_user_cannot_register_with_invalid_username(array $data, string $errorField, string $errorMessage)
    {
        $response = $this->postJson('/api/register', $data);

        $response->assertStatus(422)
                ->assertJsonValidationErrors($errorField)
                ->assertJsonFragment([$errorMessage]);
    }

    #[DataProvider('invalidEmailProvider')]
    public function test_user_cannot_register_with_invalid_email(array $data, string $errorField, string $errorMessage)
    {

        User::factory()->create(['email' => 'duplicate@example.com']);

        $response = $this->postJson('/api/register', $data);
    
        $response->assertStatus(422)
                 ->assertJsonValidationErrors($errorField)
                 ->assertJsonFragment([$errorMessage]);
    }

    #[DataProvider('invalidPasswordProvider')]
    public function test_user_cannot_register_with_invalid_password(array $data, string $errorField, string $errorMessage)
    {
        $response = $this->postJson('/api/register', $data);
    
        $response->assertStatus(422)
                 ->assertJsonValidationErrors($errorField)
                 ->assertJsonFragment([$errorMessage]);
    }
    public static function invalidUsernameProvider(): array
    {
        return [
            
            'Username is required' => [
                'data' => [
                    'username' => '',
                    'email' => 'valid@example.com',
                    'password' => 'Password123!',
                    'password_confirmation' => 'Password123!',
                ],
                'errorField' => 'username',
                'errorMessage' => 'The username field is required.',
            ],
            'Username must be at least 2 characters' => [
                'data' => [
                    'username' => 'a',
                    'email' => 'valid@example.com',
                    'password' => 'Password123!',
                    'password_confirmation' => 'Password123!',
                ],
                'errorField' => 'username',
                'errorMessage' => 'The username must be at least 2 characters.',
            ],
            'Username must not be greater than 20 characters' => [
                'data' => [
                    'username' => str_repeat('a', 21),
                    'email' => 'valid@example.com',
                    'password' => 'Password123!',
                    'password_confirmation' => 'Password123!',
                ],
                'errorField' => 'username',
                'errorMessage' => 'The username must not be greater than 20 characters.',
            ],
        ];

    }

    public static function invalidEmailProvider(): array
    {
        return [
            'Email is required' => [
                'data' => [
                    'username' => 'example',
                    'email' => '',
                    'password' => 'Password123!',
                    'password_confirmation' => 'Password123!',
                ],
                'errorField' => 'email',
                'errorMessage' => 'The email field is required.',
            ],
            'Email must be a valid email address' => [
                'data' => [
                    'username' => 'example',
                    'email' => 'invalid@',
                    'password' => 'Password123!',
                    'password_confirmation' => 'Password123!',
                ],
                'errorField' => 'email',
                'errorMessage' => 'The email must be a valid email address.',
            ],
            'Email has already been taken' => [
                'data' => [
                    'username' => 'example',
                    'email' => 'duplicate@example.com',
                    'password' => 'Password123!',
                    'password_confirmation' => 'Password123!',
                ],
                'errorField' => 'email',
                'errorMessage' => 'The email has already been taken.',
            ],
        ];
    }
    
    public static function invalidPasswordProvider(): array
    {
        return [
            'Password is required' => [
                'data' => [
                    'username' => 'example',
                    'email' => 'example@example.com',
                    'password' => '',
                    'password_confirmation' => '',
                ],
                'errorField' => 'password',
                'errorMessage' => 'The password field is required.',
            ],
            'Password must be at least 8 characters' => [
                'data' => [
                    'username' => 'example',
                    'email' => 'example@example.com',
                    'password' => 'passwo!',
                    'password_confirmation' => 'passwo!',
                ],
                'errorField' => 'password',
                'errorMessage' => 'The password must be at least 8 characters.',
            ],
            'Password must contain at least one special character' => [
                'data' => [
                    'username' => 'example',
                    'email' => 'example@example.com',
                    'password' => 'Password123',
                    'password_confirmation' => 'Password123',
                ],
                'errorField' => 'password',
                'errorMessage' => 'The password must contain at least one special character.',
            ],
            'Password confirmation does not match (empty confirmation)' => [
                'data' => [
                    'username' => 'example',
                    'email' => 'example@example.com',
                    'password' => 'Password123!',
                    'password_confirmation' => '',
                ],
                'errorField' => 'password',
                'errorMessage' => 'The password confirmation does not match.',
            ],
            'Password confirmation does not match (different passwords)' => [
                'data' => [
                    'username' => 'example',
                    'email' => 'example@example.com',
                    'password' => 'Password123!',
                    'password_confirmation' => 'password1564!',
                ],
                'errorField' => 'password',
                'errorMessage' => 'The password confirmation does not match.',
            ],
        ];
    }
}
