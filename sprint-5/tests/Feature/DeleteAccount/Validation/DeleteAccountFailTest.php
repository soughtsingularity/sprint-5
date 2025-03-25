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

}
