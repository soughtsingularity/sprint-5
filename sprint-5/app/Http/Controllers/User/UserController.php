<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function destroy(User $user)
    {
        $authenticatedUser = auth()->user();
    
        if ($authenticatedUser->id !== $user->id) {
            return response()->json(['message' => 'Forbidden'], 403);
        }
    
        $user->tokens()->delete();
        $user->delete();
    
        return response()->noContent(); 
    }
}
