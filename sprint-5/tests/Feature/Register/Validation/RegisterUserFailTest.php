<?php

namespace Tests\Feature\Feature\Register\Validation;

use Tests\TestCase;
use Laravel\Passport\ClientRepository;
use Illuminate\Foundation\Testing\WithFaker;
use Database\Seeders\RolesAndPermissionsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;

class RegisterUserFailTest extends TestCase
{

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(RolesAndPermissionsSeeder::class);
        $clientRepository = new ClientRepository();
        $client = $clientRepository->createPersonalAccessClient(
            null, 'Test Personal Access Client', 'http://localhost');
            config(['passport.personal_access_client.id' => $client->id]);
            config(['passport.personal_access_client.secret' => $client->secret]);        
        
    }
    public function test_user_cannot_register_with_invalid_username()
    {
        $testCases = [
            [
                'data' => [
                    'username' => '',
                    'email' => 'valid@example.com',
                    'password' => 'Password123!',
                    'password_confirmation' => 'Password123!',
                ],
                'errorField' => 'username',
                'errorMessage' => 'The username field is required.',
            ],
            [
                'data' => [
                    'username' => 'a',
                    'email' => 'valid@example.com',
                    'password' => 'Password123!',
                    'password_confirmation' => 'Password123!',
                ],
                'errorField' => 'username',
                'errorMessage' => 'The username must be at least 2 characters.',
            ],
            [
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
    
        foreach ($testCases as $case) {
            $response = $this->postJson('/api/register', $case['data']);
    
            $response->assertStatus(422)
                     ->assertJsonValidationErrors($case['errorField'])
                     ->assertJsonFragment([$case['errorMessage']]);
        }
    }

    public function test_user_cannot_register_with_invalid_email()
    {

        User::factory()->create(['email' => 'duplicate@example.com']);

        $testCases = [
            [
                'data' => [
                    'username' => 'example',
                    'email' => '',
                    'password' => 'Password123!',
                    'password_confirmation' => 'Password123!',
                ],
                'errorField' => 'email',
                'errorMessage' => 'The email field is required.',
            ],
            [
                'data' => [
                    'username' => 'example',
                    'email' => 'invalid@',
                    'password' => 'Password123!',
                    'password_confirmation' => 'Password123!',
                ],
                'errorField' => 'email',
                'errorMessage' => 'The email must be a valid email address.',
            ],
            [
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

        foreach($testCases as $case) {
            $response = $this->postJson('/api/register', $case['data']);

            $response->assertStatus(422)
                     ->assertJsonValidationErrors($case['errorField'])
                     ->assertJsonFragment([$case['errorMessage']]);

        }
    }
}
