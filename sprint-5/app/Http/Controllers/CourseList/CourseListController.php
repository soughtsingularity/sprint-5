<?php

namespace App\Http\Controllers\CourseList;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Http\Resources\FullCourseResource;
use App\Http\Resources\PublicCourseResource;
use Illuminate\Support\Facades\Auth;

class CourseListController extends Controller
{

        /**
     * @OA\Get(
     *     path="/api/courses",
     *     summary="List all public courses",
     *     description="Returns a list of all courses available to the public. No authentication required.",
     *     tags={"Courses"},
     * 
     *     @OA\Response(
     *         response=200,
     *         description="List of courses retrieved successfully",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="id", type="integer", example=1),
     *                     @OA\Property(property="title", type="string", example="Laravel Basics")
     *                 )
     *             )
     *         )
     *     )
     * )
     *
     * Headers para Postman:
     * - Accept: application/json
     */


    public function index()
    {
        $courses = Course::all();
        return PublicCourseResource::collection($courses);
    }

        /**
     * @OA\Get(
     *     path="/api/courses/{course}",
     *     summary="Get full details of a specific course",
     *     description="Returns detailed information about a specific course, including chapters and videos. If authenticated, the response includes the user's enrollment status, progress, completed chapters and medal.",
     *     tags={"Courses"},
     *
     *     @OA\Parameter(
     *         name="course",
     *         in="path",
     *         required=true,
     *         description="ID of the course to retrieve",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Course details retrieved successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="title", type="string", example="Laravel Mastery"),
     *                 @OA\Property(property="description", type="string", example="Complete Laravel course from beginner to advanced"),
     *                 @OA\Property(property="content", type="array",
     *                     @OA\Items(
     *                         @OA\Property(property="title", type="string", example="Chapter 1"),
     *                         @OA\Property(property="description", type="string", example="Introduction to Laravel"),
     *                         @OA\Property(property="videos", type="array",
     *                             @OA\Items(
     *                                 @OA\Property(property="title", type="string", example="Setup Environment"),
     *                                 @OA\Property(property="description", type="string", example="Installation steps"),
     *                                 @OA\Property(property="url", type="string", example="https://www.youtube.com/embed/abc123")
     *                             )
     *                         )
     *                     )
     *                 ),
     *                 @OA\Property(property="users", type="array", @OA\Items(type="object")), 
     *                 @OA\Property(property="progress", type="integer", example=100),
     *                 @OA\Property(property="completed", type="string", example="[0]"),
     *                 @OA\Property(property="medal", type="string", example="gold"),
     *                 @OA\Property(property="is_enrolled", type="boolean", example=true)
     *             ),
     *             @OA\Property(property="auth_user", type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="email", type="string", example="user@example.com")
     *             )
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=404,
     *         description="Course not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="No query results for model [App\\Models\\Course] 999.")
     *         )
     *     )
     * )
     *
     * Headers para Postman (opcional):
     * - Accept: application/json
     * - Authorization: Bearer {token}
     */


    public function show($id)
    {
        if ($token = request()->bearerToken()) {
            Auth::shouldUse('api');
    
            try {
                $user = Auth::user();
            } catch (\Exception $e) {
                $user = null;
            }
        } else {
            $user = null;
        }
    
        $course = Course::with('users')->findOrFail($id);
    
        return (new FullCourseResource($course))->additional(['auth_user' => $user]);
    }
 
}
