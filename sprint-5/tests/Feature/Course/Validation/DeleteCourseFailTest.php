<?php

namespace Tests\Feature\Course\Validation;

use App\Models\Course;
use App\Models\User;
use Tests\ApiTestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DeleteCourseFailTest extends ApiTestCase
{
    use RefreshDatabase;

    public function test_admin_cannot_delete_course_without_token()
    {
        //$this->withoutExceptionHandling();

        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $course = Course::factory()->create();

        $response = $this->deleteJson('/api/courses/' . $course->id);

        $response->assertStatus(401);
        $response->assertJson([
            'message' => 'Unauthenticated.',
        ]);
    }

    public function test_admin_cannot_delete_course_with_invalid_token()
    {
        //$this->withoutExceptionHandling();

        $course = Course::factory()->create();
        $admin = User::factory()->create();
        $admin->assignRole('admin');
        $token = "Invalid token";

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->deleteJson('/api/courses/' . $course->id);

        $response->assertStatus(401);
        $response->assertJson([
            'message' => 'Unauthenticated.',
        ]);
    }

    public function test_admin_cannot_delete_inexistent_course()
    {
        $admin = User::factory()->create();
        $course = Course::factory()->create();
        $admin->assignRole('admin');
        $token = $admin->createToken('admin-token')->accessToken;
        
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->deleteJson('/api/courses/' . $course->id + 1);
    
        $response->assertStatus(404);
    }

    public function test_user_cannot_delete_course()
    {
        //$this->withoutExceptionHandling();

        $user = User::factory()->create();
        $user->assignRole('user');
        $course = Course::factory()->create();
        $token = $user->createToken('user-token')->accessToken;

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->deleteJson('/api/courses/' . $course->id);

        $response->assertStatus(403);
    }
    
}
