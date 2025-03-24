<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginUserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(LoginUserRequest $request)
    {
        $credentials = $request->validated();
    
        $user = Auth::user();
    
        return response()->json([
            'message' => 'User logged in successfully',
            'user' => $user,
        ], 200);
    }
}