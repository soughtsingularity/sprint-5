<?php

namespace App\Http\Controllers\CourseList;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;

class CourseListController extends Controller
{
    public function index()
    {
        $courses = Course::all();

        return response()->json([
            'data' => $courses,
        ]);
    }
}
