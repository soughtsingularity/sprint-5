<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\User\UserCourseController;
use App\Http\Controllers\Admin\CourseController;

Route::post('/register', [RegisterController::class, 'register']);
Route::post('login', [LoginController::class, 'login']);

Route::middleware('auth:api')->group(function () {

    Route::middleware('role:user')->group(function () {
        Route::middleware('permission:delete-account')
            ->delete('/users/{user}', [UserController::class, 'destroy']);

        Route::middleware('permission:enroll-course')
            ->post('/courses/{course}/enroll', [UserCourseController::class, 'enroll']);
    });

    Route::middleware('role:admin')->group(function () {
        Route::middleware('permission:create-course')
            ->post('/courses', [CourseController::class, 'store']);
    });

});

