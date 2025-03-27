<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Course>
 */
class CourseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->title(),
            'description' => fake()->paragraph(),
            'videos' => [
                [
                    'title' => fake()->title(),
                    'description' => fake()->paragraph(),
                    'url' => 'https://www.youtube.com/embed/video1'
                ],
                [
                    'title' => fake()->title(),
                    'description' => fake()->paragraph(),
                    'url' => 'https://www.youtube.com/embed/video2'
                ]
            ]
        ];
    }
}
