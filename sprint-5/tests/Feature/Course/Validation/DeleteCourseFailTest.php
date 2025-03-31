<?php

namespace Tests\Feature\Course\Validation;

use App\Models\Course;
use Tests\ApiTestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DeleteCourseFailTest extends ApiTestCase
{
    use RefreshDatabase;

    public function test_admin_cannot_delete_course_without_token()
    {
        //$this->withoutExceptionHandling();

        $course = Course::factory()->create();

        $response = $this->deleteJson('/api/courses/' . $course->id);

        $response->assertStatus(401);
        $response->assertJson([
            'message' => 'Unauthenticated.',
        ]);
    }
}
