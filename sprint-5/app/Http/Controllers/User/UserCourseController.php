<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;

class UserCourseController extends Controller
{

    /**
     * @OA\Post(
     *     path="/api/courses/{course}/enroll",
     *     summary="Enroll in a course",
     *     description="Allows an authenticated user with the 'user' role and appropriate permission to enroll in a course. Returns a confirmation message or a conflict if already enrolled.",
     *     tags={"User Courses"},
     *     security={{"passport": {}}},
     *
     *     @OA\Parameter(
     *         name="course",
     *         in="path",
     *         required=true,
     *         description="ID of the course to enroll in",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Enrolled successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="You have successfully enrolled in the course")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized - missing or invalid token",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Unauthenticated.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=409,
     *         description="Conflict - user already enrolled in course",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="You have already enrolled in the course")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Course not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="No query results for model [App\\Models\\Course] 999")
     *         )
     *     )
     * )
     *
     * Headers para Postman:
     * - Accept: application/json
     * - Content-Type: application/json
     * - Authorization: Bearer {token}
     */



    public function enroll(Course $course)
    {
        $user = auth()->user();

        if($course->users()->where('user_id', $user->id)->exists()) {
            return response()->json([
                'message' => 'You have already enrolled in the course',
            ], 409);
        }

        $user->courses()->attach($course->id, [
            'progress' => 0,
            'completed_chapters' => json_encode([]),
            'medal' => null
        ]);

        return response()->json([
            'message' => 'You have successfully enrolled in the course',
        ], 200);
    }

        /**
     * @OA\Post(
     *     path="/api/courses/{course}/unenroll",
     *     summary="Unenroll from a course",
     *     description="Allows an authenticated user to unenroll from a course they are currently enrolled in. Returns a confirmation message or a conflict if the user is not enrolled.",
     *     tags={"User Courses"},
     *     security={{"passport": {}}},
     *
     *     @OA\Parameter(
     *         name="course",
     *         in="path",
     *         required=true,
     *         description="ID of the course to unenroll from",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Unenrolled successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="You have successfully unenrolled from the course")
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized - missing or invalid token",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Unauthenticated.")
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=409,
     *         description="Conflict - user is not enrolled in the course",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="You have not enrolled in the course")
     *         )
     *     ),
     *  *     @OA\Response(
     *         response=404,
     *         description="Course not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="No query results for model [App\\Models\\Course] 999")
     *         )
     *     )
     * )
     *
     * Headers para Postman:
     * - Accept: application/json
     * - Content-Type: application/json
     * - Authorization: Bearer {token}
     */


    public function unenroll(Course $course)
    {
        $user = auth()->user();

        if(!$course->users()->where('user_id', $user->id)->exists()) {
            return response()->json([
                'message' => 'You have not enrolled in the course',
            ], 409);
        }

        $user->courses()->detach($course->id);

        return response()->json([
            'message' => 'You have successfully unenrolled from the course',
        ], 200);
    }
}
