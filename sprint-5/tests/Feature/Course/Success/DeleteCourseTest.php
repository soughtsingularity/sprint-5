<?php

namespace Tests\Feature\Course\Success;

use App\Models\Course;
use App\Models\User;
use Tests\ApiTestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DeleteCourseTest extends ApiTestCase
{
    use RefreshDatabase;

    public function test_admin_can_delete_course()
    {
        $this->withoutExceptionHandling();

        $admin = User::factory()->create();
        $course = Course::factory()->create();

        $token = $admin->createToken('admin-token')->accessToken;

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->deleteJson('/api/courses/' . $course->id);

        $response->assertStatus(200);
        
        $response->assertJson([
            'message' => 'Course deleted successfully',
        ]);
        $this->assertDatabaseMissing('courses', [
            'id' => $course->id,
        ]);
    }
}
