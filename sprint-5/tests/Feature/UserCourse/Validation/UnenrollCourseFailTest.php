<?php

namespace Tests\Feature\UserCourse\Validation;

use Tests\ApiTestCase;
use App\Models\User;
use App\Models\Course;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UnenrollCourseFailTest extends ApiTestCase
{
    use RefreshDatabase;

    public function test_unenroll_course_without_token()
    {
        //$this->withpoutExceptionHandling();
        $user = User::factory()->create();
        $course = Course::factory()->create();
        $user->courses()->attach($course->id);

        $response = $this->postJson("/api/courses/{$course->id}/unenroll");
        $response->assertStatus(401)
            ->assertJson([
                'message' => 'Unauthenticated.',
            ]);
    }

    public function test_unenroll_course_with_invalid_token()
    {
        //$this->withoutExceptionHandling();
        $user = User::factory()->create();
        $course = Course::factory()->create();
        $user->courses()->attach($course->id);

        $token = 'invalid-token';

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->postJson("/api/courses/{$course->id}/unenroll");

        $response->assertStatus(401)
            ->assertJson([
                'message' => 'Unauthenticated.',
        ]);
    }

    public function test_unenroll_course_if_user_is_not_in_the_course()
    {
        //$this->withoutExceptionHandling();

        $user = User::factory()->create();
        $course = Course::factory()->create();
        $user->assignRole('user');
        $token = $user->createToken('authToken')->accessToken;
        
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->postJson("/api/courses/{$course->id}/unenroll");

        $response->assertStatus(409)
            ->assertJson([
                'message' => 'You have not enrolled in the course',
            ]);
    }
}
