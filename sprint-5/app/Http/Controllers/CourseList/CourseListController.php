<?php

namespace App\Http\Controllers\CourseList;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Http\Resources\FullCourseResource;
use App\Http\Resources\PublicCourseResource;

class CourseListController extends Controller
{
    /**
 * @OA\Get(
 *     path="/api/courses",
 *     summary="List all available courses",
 *     tags={"Courses"},
 *     @OA\Response(
 *         response=200,
 *         description="List of available courses",
 *         @OA\JsonContent(
 *             @OA\Property(
 *                 property="data",
 *                 type="array",
 *                 @OA\Items(
 *                     type="object",
 *                     @OA\Property(property="id", type="integer", example=1),
 *                     @OA\Property(property="title", type="string", example="Test Course")
 *                 )
 *             )
 *         )
 *     )
 * )
 */

    public function index()
    {
        $courses = Course::all();
        return PublicCourseResource::collection($courses);
    }

    /**
 * @OA\Get(
 *     path="/api/courses/{course}",
 *     summary="Get full details of a course by ID",
 *     tags={"Courses"},
 *     @OA\Parameter(
 *         name="course",
 *         in="path",
 *         required=true,
 *         description="ID of the course to retrieve",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Course details retrieved successfully",
 *         @OA\JsonContent(
 *             @OA\Property(property="data", type="object",
 *                 @OA\Property(property="id", type="integer", example=1),
 *                 @OA\Property(property="title", type="string", example="Test Course"),
 *                 @OA\Property(property="description", type="string", example="This is a test course"),
 *                 @OA\Property(
 *                     property="content",
 *                     type="array",
 *                     @OA\Items(
 *                         type="object",
 *                         @OA\Property(property="title", type="string", example="Capítulo 1"),
 *                         @OA\Property(property="description", type="string", example="Descripción del capítulo 1"),
 *                         @OA\Property(
 *                             property="videos",
 *                             type="array",
 *                             @OA\Items(
 *                                 type="object",
 *                                 @OA\Property(property="title", type="string", example="Test Video 1"),
 *                                 @OA\Property(property="description", type="string", example="This is a test video 1"),
 *                                 @OA\Property(property="url", type="string", format="url", example="https://www.youtube.com/watch?v=123456")
 *                             )
 *                         )
 *                     )
 *                 )
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Course not found",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="Course not found")
 *         )
 *     )
 * )
 */

    public function show($id)
    {
        $course = Course::with('users')->findOrFail($id);
        return new FullCourseResource($course);
    }
}
