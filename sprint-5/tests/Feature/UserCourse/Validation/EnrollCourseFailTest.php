<?php

namespace Tests\Feature\UserCourse\Validation;

use Tests\TestCase;
use App\Models\User;
use App\Models\Course;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\ApiTestCase;

class EnrollCourseFailTest extends ApiTestCase
{
    public function test_enroll_course_without_token()
    {
        //$this->withoutExceptionHandling();

        $user = User::factory()->create();
        $course = Course::factory()->create();
        $user->assignRole('user');
        $user->hasPermissionTo('enroll-course');

        $response = $this->postJson("/api/courses/{$course->id}/enroll");

        $response->assertStatus(401)
            ->assertJson([
                'message' => 'Unauthenticated.'
            ]);
    }

    public function test_enroll_course_with_invalid_token()
    {
        //$this->withoutExceptionHandling();

        $user = User::factory()->create();
        $course = Course::factory()->create();
        $user->assignRole('user');
        $user->hasPermissionTo('enroll-course');

        $token = 'invalid-token';

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->postJson("/api/courses/{$course->id}/enroll");

        $response->assertStatus(401)
            ->assertJson([
                'message' => 'Unauthenticated.'
            ]);
    }

    public function test_enroll_course_more_than_one_time()
    {
        //$this->withoutExceptionHandling();

        $user = User::factory()->create();
        $course = Course::factory()->create();
        $user->assignRole('user');
        $user->hasPermissionTo('enroll-course');

        $token = $user->createToken('authToken')->accessToken;

        $user->courses()->attach($course->id);

        $this->assertDatabaseHas('course_user', [
            'course_id' => $course->id,
            'user_id' => $user->id,
        ]);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->postJson("/api/courses/{$course->id}/enroll");

        $response->assertStatus(409)
            ->assertJson([
                'message' => 'You have already enrolled in the course',
            ]);
    }

        public function test_enroll_course_in_nonexistent_course()
    {
        $user = User::factory()->create();
        $course = Course::factory()->create();
        $user->assignRole('user');
        $user->givePermissionTo('enroll-course');

        $token = $user->createToken('authToken')->accessToken;

        $nonExistentCourseId = $course->id + 1;

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->postJson("/api/courses/{$nonExistentCourseId}/enroll");

        $response->assertStatus(404);
    }


}
