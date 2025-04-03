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
 *     summary="Enroll user in a course",
 *     description="Allows an authenticated user with role 'user' and permission 'enroll-course' to enroll in a course. Returns 409 if already enrolled.",
 *     operationId="enrollCourse",
 *     tags={"Courses"},
 *
 *     security={{"passport": {}}},
 *
 *     @OA\Parameter(
 *         name="course",
 *         in="path",
 *         description="ID of the course to enroll in",
 *         required=true,
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *
 *     @OA\Response(
 *         response=200,
 *         description="Enrollment successful",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="You have successfully enrolled in the course")
 *         )
 *     ),
 * 
 *     @OA\Response(
 *         response=401,
 *         description="Unauthorized - Missing or invalid token",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="Unauthenticated.")
 *         )
 *     ),
 *
 *     @OA\Response(
 *         response=403,
 *         description="Forbidden - User lacks role or permission",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="User does not have the right roles.")
 *         )
 *     ),
 *
 *     @OA\Response(
 *         response=409,
 *         description="Conflict - Already enrolled",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="You have already enrolled in the course")
 *         )
 *     )
 * )
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
 *     summary="Unenroll user from a course",
 *     description="Allows an authenticated user with role 'user' and permission 'unenroll-course' to unenroll from a course. Returns 409 if the user is not enrolled.",
 *     operationId="unenrollCourse",
 *     tags={"Courses"},
 *
 *     security={{"passport": {}}},
 *
 *     @OA\Parameter(
 *         name="course",
 *         in="path",
 *         description="ID of the course to unenroll from",
 *         required=true,
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *
 *     @OA\Response(
 *         response=200,
 *         description="Unenrollment successful",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="You have successfully unenrolled from the course")
 *         )
 *     ),
 *
 *     @OA\Response(
 *         response=401,
 *         description="Unauthorized - Missing or invalid token",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="Unauthenticated.")
 *         )
 *     ),
 *
 *     @OA\Response(
 *         response=403,
 *         description="Forbidden - User lacks role or permission",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="User does not have the right roles.")
 *         )
 *     ),
 *
 *     @OA\Response(
 *         response=409,
 *         description="Conflict - User not enrolled",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="You have not enrolled in the course")
 *         )
 *     )
 * )
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
