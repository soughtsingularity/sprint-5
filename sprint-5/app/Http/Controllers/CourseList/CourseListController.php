<?php

namespace App\Http\Controllers\CourseList;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Http\Resources\FullCourseResource;
use App\Http\Resources\PublicCourseResource;

class CourseListController extends Controller
{
    public function index()
    {
        $courses = Course::all();
        return PublicCourseResource::collection($courses);
    }

    public function show($id)
    {
        $course = Course::findOrFail($id);
        return new FullCourseResource($course);
    }


}
