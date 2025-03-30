<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;

class UserController extends Controller
{
    public function show(User $user)
    {    
        $user->load('courses:id,title');

        if($user->id !== auth()->user()->id && !auth()->user()->hasRole('admin')) {
            return response()->json(['message' => 'Forbidden'], 403);
        }
    
        return new UserResource($user);
    }

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
