<?php

namespace Tests\Feature\Course\Success;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\ApiTestCase;
use App\Models\User;

class GetAllCoursesTest extends ApiTestCase
{
    use RefreshDatabase;
    public function test_everyone_can_get_all_courses()
    {
        $this->withoutExceptionHandling();

        $response = $this->getJson('/api/courses');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'title',
                        'description',
                        'content' => [
                            '*' => [
                                'title',
                                'description',
                                'videos' => [
                                    '*' => [
                                        'title',
                                        'description',
                                        'url',
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ]);
    }
}
