<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Admin\CourseController;

Route::post('/register', [RegisterController::class, 'register']);

Route::post('login', [LoginController::class, 'login']);

Route::middleware(['auth:api', 'role:user','permission:delete-account'])
    ->delete('/users/{user}', [UserController::class, 'destroy']);

Route::middleware(['auth:api', 'role:admin', 'permission:create-course'])
    ->post('/courses', [CourseController::class, 'store']);