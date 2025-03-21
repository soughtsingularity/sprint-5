<?php

namespace Tests\Feature\Feature\Register\Validation;

use Tests\TestCase;
use Laravel\Passport\ClientRepository;
use Illuminate\Foundation\Testing\WithFaker;
use Database\Seeders\RolesAndPermissionsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;

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
}
