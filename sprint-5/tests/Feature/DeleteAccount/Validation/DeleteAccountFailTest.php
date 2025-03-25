<?php

namespace Tests\Feature\DeleteAccount\Validation;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use Laravel\Passport\Passport;
use Tests\ApiTestCase;

class DeleteAccountFailTest extends ApiTestCase
{
    /**
     * A basic feature test example.
     */

        public function test_user_cannot_delete_other_user_account(): void
        {
        $userA = User::factory()->create();
        $userA->assignRole('user');

        $userB = User::factory()->create();
        $userB->assignRole('user');

        Passport::actingAs($userA);

        $response = $this->deleteJson("/api/users/{$userB->id}");

        $response->assertStatus(403);

        $this->assertDatabaseHas('users', [
            'id' => $userB->id,
        ]);
     }

        public function test_user_cannot_delete_account_with_invalid_token(): void
        {
            $user = User::factory()->create();
            $user->assignRole('user');
        
            $invalidToken = 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.invalid.signature';
        
            $response = $this->withHeaders([
                'Authorization' => $invalidToken
            ])->deleteJson("/api/users/{$user->id}");
        
            $response->assertStatus(401);
        
            $this->assertDatabaseHas('users', [
                'id' => $user->id,
            ]);
        }
     


}
