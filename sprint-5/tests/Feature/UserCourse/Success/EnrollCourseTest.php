<?php

namespace Tests\Feature\Course\Success;

use App\Models\Course;
use Tests\ApiTestCase;
use App\Models\User;
use Laravel\Passport\Passport;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EnrollCourseTest extends ApiTestCase
{
    use RefreshDatabase;
    public function test_authenticated_user_can_enroll_in_a_course()
    {
        $this->withoutExceptionHandling();

        $user = User::factory()->create();
        $course = Course::factory()->create();
        $user->assignRole('user');
        $user->hasPermissionTo('enroll-course');

        Passport::actingAs($user);

        $token = $user->createToken('authToken')->accessToken;

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->postJson("/api/courses/{$course->id}/enroll");
    
        $response->assertStatus(200)
        ->assertJson([
            'message' => 'You have successfully enrolled in the course',
        ]);

        $this->assertDatabaseHas('course_user', [
            'course_id' => $course->id,
            'user_id' => $user->id,
        ]);
    }



}
