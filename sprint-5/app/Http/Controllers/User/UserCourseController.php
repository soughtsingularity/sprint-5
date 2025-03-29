<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;

class UserCourseController extends Controller
{
    public function enroll(Course $course)
    {
        $user = auth()->user();

        if($course->users()->where('user_id', $user->id)->exists()) {
            return response()->json([
                'message' => 'You have already enrolled in the course',
            ], 409);
        }

        $user->courses()->attach($course->id);


        return response()->json([
            'message' => 'You have successfully enrolled in the course',
        ], 200);
    }

    public function unenroll(Course $course)
    {
        $user = auth()->user();

        

        $user->courses()->detach($course->id);

        return response()->json([
            'message' => 'You have successfully unenrolled from the course',
        ], 200);
    }
}
