<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\CourseCreateRequest;

class CourseController extends Controller
{
    public function store(CourseCreateRequest $request)
    {
        return response()->json(['message' => 'OK'], 201);
    }
}
