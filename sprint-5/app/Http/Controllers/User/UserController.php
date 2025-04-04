<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UserController extends Controller
{
        /**
     * @OA\Get(
     *     path="/api/users",
     *     summary="Get all users with their enrolled courses",
     *     description="Returns a list of all users with their associated courses, including progress and medal. Only accessible to authenticated admin users.",
     *     tags={"Users"},
     *     security={{"passport": {}}},
     *
     *     @OA\Response(
     *         response=200,
     *         description="Users retrieved successfully",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(
     *                     @OA\Property(property="id", type="integer", example=1),
     *                     @OA\Property(property="username", type="string", example="adminuser"),
     *                     @OA\Property(property="email", type="string", example="admin@example.com"),
     *                     @OA\Property(
     *                         property="courses",
     *                         type="array",
     *                         @OA\Items(
     *                             @OA\Property(property="id", type="integer", example=1),
     *                             @OA\Property(property="title", type="string", example="Laravel Basics"),
     *                             @OA\Property(property="description", type="string", example="Course description"),
     *                             @OA\Property(property="progress", type="integer", example=80),
     *                             @OA\Property(property="medal", type="string", example="silver")
     *                         )
     *                     )
     *                 )
     *             )
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized - missing or invalid token",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Unauthenticated.")
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=403,
     *         description="Forbidden - user does not have admin role",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Forbidden")
     *         )
     *     )
     * )
     *
     * Headers para Postman:
     * - Accept: application/json
     * - Content-Type: application/json
     * - Authorization: Bearer {token}
     */

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

        /**
     * @OA\Get(
     *     path="/api/users/{user}",
     *     summary="Get user information",
     *     description="Returns the authenticated user's information and their enrolled courses. Admin users can view any user's data. Regular users can only access their own information.",
     *     tags={"Users"},
     *     security={{"passport": {}}},
     *
     *     @OA\Parameter(
     *         name="user",
     *         in="path",
     *         required=true,
     *         description="ID of the user to retrieve",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="User information retrieved successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="username", type="string", example="exampleUser"),
     *                 @OA\Property(property="email", type="string", example="user@example.com"),
     *                 @OA\Property(
     *                     property="courses",
     *                     type="array",
     *                     @OA\Items(
     *                         @OA\Property(property="id", type="integer", example=1),
     *                         @OA\Property(property="title", type="string", example="Laravel Basics"),
     *                         @OA\Property(property="progress", type="integer", example=95),
     *                         @OA\Property(property="medal", type="string", example="gold")
     *                     )
     *                 )
     *             )
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized - missing or invalid token",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Unauthenticated.")
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=403,
     *         description="Forbidden - user lacks permission to view this resource",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Forbidden")
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=404,
     *         description="User not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="User not found")
     *         )
     *     )
     * )
     *
     * Headers para Postman:
     * - Accept: application/json
     * - Content-Type: application/json
     * - Authorization: Bearer {token}
     */



     public function show(User $user)
     {
         try {
             $user->load(['courses' => function ($query) {
                 $query->addSelect('courses.id', 'courses.title') 
                       ->withPivot('progress', 'medal', 'completed_chapters');
             }]);
             
             
                 
             if ($user->id !== auth()->id() && !auth()->user()->hasRole('admin')) {
                 return response()->json(['message' => 'Forbidden'], 403);
             }
     
             return new UserResource($user);
         } catch (ModelNotFoundException $e) {
             return response()->json(['message' => 'User not found'], 404);
         }
     }

         /**
     * @OA\Delete(
     *     path="/api/users/{user}",
     *     summary="Delete the authenticated user's account",
     *     description="Allows a user to delete **only their own account**. Also deletes all access tokens associated with the user. Requires authentication and 'user' role.",
     *     tags={"Users"},
     *     security={{"passport": {}}},
     *
     *     @OA\Parameter(
     *         name="user",
     *         in="path",
     *         required=true,
     *         description="ID of the user to delete (must match the authenticated user)",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *
     *     @OA\Response(
     *         response=204,
     *         description="User account deleted successfully. No content is returned."
     *     ),
     *
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized - missing or invalid token",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Unauthenticated.")
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=403,
     *         description="Forbidden - trying to delete another user's account or lacking role",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Forbidden")
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=404,
     *         description="User not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="No query results for model [App\\Models\\User] 999.")
     *         )
     *     )
     * )
     *
     * Headers para Postman:
     * - Accept: application/json
     * - Content-Type: application/json
     * - Authorization: Bearer {token}
     */

 
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
 
