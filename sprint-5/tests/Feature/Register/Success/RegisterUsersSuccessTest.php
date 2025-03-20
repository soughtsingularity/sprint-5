<?php

namespace Tests\Feature\Register\Success;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Database\Seeders\RolesAndPermissionsSeeder;

class RegisterUsersSuccessTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(RolesAndPermissionsSeeder::class);
    }
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

    public function test_new_user_have_user_role()
    {

        $userData = [
            'username' => 'testuser',
            'email' => 'test@example.com',
            'password' => 'password123!',
            'password_confirmation' => 'password123!',
        ];

        $response = $this->postJson('/api/register', $userData);

        $response->assertStatus(201)
            ->assertJsonStructure(['message', 'user']);

        $user = User::where('email', $userData['email'])->first();

        $this->assertEquals($user->hasRole('user'), true);


    }

}

