<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginUserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
 * @OA\Post(
 *     path="/api/login",
 *     summary="Authenticate a user and return a token",
 *     tags={"Authentication"},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"email", "password"},
 *             @OA\Property(property="email", type="string", format="email", example="user@test.com"),
 *             @OA\Property(property="password", type="string", format="password", example="password123!")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="User logged in successfully",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="User logged in successfully"),
 *             @OA\Property(property="user", type="object",
 *                 @OA\Property(property="id", type="integer", example=1),
 *                 @OA\Property(property="username", type="string", example="test_user"),
 *                 @OA\Property(property="email", type="string", example="user@test.com"),
 *                 @OA\Property(property="role", type="string", example="user"),
 *                 @OA\Property(property="email_verified_at", type="string", format="date-time", example="2025-03-31T15:49:49.000000Z"),
 *                 @OA\Property(property="created_at", type="string", format="date-time", example="2025-03-31T15:49:49.000000Z"),
 *                 @OA\Property(property="updated_at", type="string", format="date-time", example="2025-03-31T15:49:49.000000Z")
 *             ),
 *             @OA\Property(property="token", type="string", example="eyJ0eXAiOiJKV1QiLCJhbGciOi...")
 *         )
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Invalid credentials",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="Invalid credentials")
 *         )
 *     ),
 *     @OA\Response(
 *         response=422,
 *         description="Validation error",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="The given data was invalid."),
 *             @OA\Property(property="errors", type="object",
 *                 example={
 *                     "email": {
 *                         "The email field is required."
 *                     }
 *                 }
 *             )
 *         )
 *     )
 * )
 */
    public function login(LoginUserRequest $request)
    {
        $credentials = $request->validated();

        if (!Auth::attempt($credentials)) {
            return response()->json([ 
                'message' => 'Invalid credentials'
            ], 401);        
        }
    
        $user = Auth::user();
        
        $token = $user->createToken('authToken')->accessToken;

        return response()->json([
            'message' => 'User logged in successfully',
            'user' => $user,
            'token' => $token
        ], 200);
    }
}