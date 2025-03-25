<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function destroy(Request $request)
    {
        $user = $request->user();

        $user->tokens()->delete();
    
        $user->delete();
    
        return response()->noContent();
    }
    
}
