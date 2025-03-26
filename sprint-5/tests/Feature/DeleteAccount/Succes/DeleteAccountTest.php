<?php

namespace Tests\Feature\DeleteAccount\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Tests\ApiTestCase;
use App\Models\User;
use Laravel\Passport\Passport;

class DeleteAccountTest extends ApiTestCase
{

    public function test_user_can_delete_his_account()
    {
        $user = User::factory()->create();
        $user->assignRole('user');
        $user->givePermissionTo('delete-account');

        Passport::actingAs($user);

        $response = $this->deleteJson('/api/users/' . $user->id);

        $response->assertStatus(204);

        $this->assertDataBaseMissing('users', [
            'id' => $user->id,
        ]);

        $this->assertDatabaseMissing('oauth_access_tokens', ['user_id' => $user->id]);

    }
}
