<?php

namespace Tests\Feature\Course\Validation;

use Tests\TestCase;
use App\Models\User;
use Laravel\Passport\Passport;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery\Generator\StringManipulation\Pass\Pass;
use Tests\ApiTestCase;

class CreateCourseFailTest extends ApiTestCase
{
    public function test_create_course_without_token()
    {
        $courseData = [
            'title' => 'Course Without Token',
            'description' => 'Course Without Token Description',
            'videos' => [[
                    'title' => 'Video 1',
                    'description' => 'Video 1 Description',
                ]] 
        ];

        $response = $this->postJson('/api/courses', $courseData);

        $response->assertStatus(401);
    }

    public function test_create_course_without_admin_role()
    {
        $user = User::where('email', 'user@test.com')->first();
        Passport::actingAs($user);

        $courseData = [
            'title' => 'Course Without Admin Role',
            'description' => 'Course Without Admin Role Description',
            'videos' => [[
                    'title' => 'Video 1',
                    'description' => 'Video 1 Description',
                    'url' => 'https://www.youtube.com/watch?v=123456'
                ]]
            ];

            $response = $this->postJson('/api/courses', $courseData);
            $response->assertStatus(403);
    }

    public function test_create_course_with_invalid_token()
    {
        $response = $this->withHeaders([
            'Authorization' => 'Bearer fake.invalid.token'
        ])->postJson('/api/courses', []);

        $response->assertStatus(401);
    }
}
