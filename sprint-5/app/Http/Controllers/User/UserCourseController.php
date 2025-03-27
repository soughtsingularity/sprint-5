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

        $user->courses()->attach($course->id);

        return response()->json([
            'message' => 'You have successfully enrolled in the course',
        ]);
    }
}
