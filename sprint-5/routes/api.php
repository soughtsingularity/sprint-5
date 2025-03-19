<?php

use Illuminate\Support\Facades\Route;

Route::post('/register', [RegisterController::class, 'register']);

