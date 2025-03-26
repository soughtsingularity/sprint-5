<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\CourseCreateRequest;
use App\Models\Course;

class CourseController extends Controller
{
    public function store(CourseCreateRequest $request)
    {
        $course = Course::create($request->validated());
        return response()->json($course, 201);
    
    }
}
