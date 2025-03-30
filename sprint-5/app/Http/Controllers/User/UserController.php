<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UserController extends Controller
{
    public function index()
    {
        $user = auth()->user();
    
        if ($user->hasRole('admin')) {
            $users = User::with('courses')->get();            
            return UserResource::collection($users);
            
        } else {
            return response()->json(['message' => 'Forbidden'], 403);
        }
    }

    public function show(User $user)
    {
        try {
            $user->load('courses:id,title');
    
            if ($user->id !== auth()->id() && !auth()->user()->hasRole('admin')) {
                return response()->json(['message' => 'Forbidden'], 403);
            }
    
            return new UserResource($user);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'User not found'], 404);
        }
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
