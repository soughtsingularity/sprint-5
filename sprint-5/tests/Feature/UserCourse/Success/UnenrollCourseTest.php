<?php

namespace Tests\Feature\UserCourse\Success;

use Tests\ApiTestCase;
use App\Models\User;
use App\Models\Course;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UnenrollCourseTest extends ApiTestCase
{
    use RefreshDatabase;

    public function test_user_can_unenroll_of_a_course()
    {
        
        $this->withoutExceptionHandling();

        $user = User::factory()->create();
        $course = Course::factory()->create();
        $user->assignRole('user');

        $user->courses()->attach($course->id);

        $token = $user->createToken('authToken')->accessToken;
        
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->postJson("/api/courses/{$course->id}/unenroll");

        $response->assertStatus(200)
            ->assertJson([
                'message' => 'You have successfully unenrolled from the course',
            ]);

        $this->assertDatabaseMissing('course_user', [
            'user_id' => $user->id,
            'course_id' => $course->id,
        ]);
    }

}
