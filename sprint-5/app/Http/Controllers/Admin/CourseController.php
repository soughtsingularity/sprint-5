<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\CourseCreateRequest;
use App\Models\Course;

class CourseController extends Controller
{

        /**
     * @OA\Post(
     *     path="/api/courses",
     *     summary="Create a new course",
     *     description="Allows an authenticated admin user with the 'create-course' permission to create a new course with multiple chapters and YouTube videos.",
     *     tags={"Courses"},
     *     security={{"passport": {}}},
     *
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"title", "description", "content"},
     *             @OA\Property(property="title", type="string", example="Advanced Laravel"),
     *             @OA\Property(property="description", type="string", example="Learn Laravel step by step"),
     *             @OA\Property(
     *                 property="content",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     required={"title", "description", "videos"},
     *                     @OA\Property(property="title", type="string", example="Chapter 1"),
     *                     @OA\Property(property="description", type="string", example="Introduction to Laravel"),
     *                     @OA\Property(
     *                         property="videos",
     *                         type="array",
     *                         @OA\Items(
     *                             type="object",
     *                             required={"title", "description", "url"},
     *                             @OA\Property(property="title", type="string", example="Getting Started"),
     *                             @OA\Property(property="description", type="string", example="Setup and first steps"),
     *                             @OA\Property(property="url", type="string", example="https://www.youtube.com/watch?v=abc123")
     *                         )
     *                     )
     *                 )
     *             )
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=201,
     *         description="Course created successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="title", type="string", example="Advanced Laravel"),
     *             @OA\Property(property="description", type="string", example="Learn Laravel step by step"),
     *             @OA\Property(
     *                 property="content",
     *                 type="array",
     *                 @OA\Items(
     *                     @OA\Property(property="title", type="string", example="Chapter 1"),
     *                     @OA\Property(property="description", type="string", example="Introduction to Laravel"),
     *                     @OA\Property(
     *                         property="videos",
     *                         type="array",
     *                         @OA\Items(
     *                             @OA\Property(property="title", type="string", example="Getting Started"),
     *                             @OA\Property(property="description", type="string", example="Setup and first steps"),
     *                             @OA\Property(property="url", type="string", example="https://www.youtube.com/embed/abc123")
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
     *         description="Forbidden - user lacks necessary role or permission",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="This action is unauthorized.")
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=422,
     *         description="Validation error",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="The given data was invalid."),
     *             @OA\Property(property="errors", type="object",
     *                 @OA\Property(property="title", type="array",
     *                     @OA\Items(type="string", example="The title field is required.")
     *                 ),
     *                 @OA\Property(property="content", type="array",
     *                     @OA\Items(type="string", example="The content must be an array.")
     *                 )
     *             )
     *         )
     *     )
     * )
     *
     * Headers para Postman:
     * - Accept: application/json
     * - Content-Type: application/json
     * - Authorization: Bearer {token}
     */


    public function store(CourseCreateRequest $request)
    {
        $data = $request->validated();
    
        foreach ($data['content'] as &$chapter) {
            foreach ($chapter['videos'] as &$video) {
                $video['url'] = $this->convertToEmbedUrl($video['url']);
            }
        }
    
        $course = Course::create($data);
    
        return response()->json($course, 201);
    }

        /**
     * @OA\Put(
     *     path="/api/courses/{course}",
     *     summary="Update an existing course",
     *     description="Allows an authenticated admin user to update an existing course, including its title, description, chapters, and embedded video URLs.",
     *     tags={"Courses"},
     *     security={{"passport": {}}},
     * 
     *     @OA\Parameter(
     *         name="course",
     *         in="path",
     *         required=true,
     *         description="ID of the course to update",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     * 
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"title", "description", "content"},
     *             @OA\Property(property="title", type="string", example="Updated Laravel Course"),
     *             @OA\Property(property="description", type="string", example="Updated course description"),
     *             @OA\Property(
     *                 property="content",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     required={"title", "description", "videos"},
     *                     @OA\Property(property="title", type="string", example="Updated Chapter 1"),
     *                     @OA\Property(property="description", type="string", example="Updated Introduction"),
     *                     @OA\Property(
     *                         property="videos",
     *                         type="array",
     *                         @OA\Items(
     *                             type="object",
     *                             required={"title", "description", "url"},
     *                             @OA\Property(property="title", type="string", example="Updated Video 1"),
     *                             @OA\Property(property="description", type="string", example="Updated description for video 1"),
     *                             @OA\Property(property="url", type="string", example="https://www.youtube.com/watch?v=updated123")
     *                         )
     *                     )
     *                 )
     *             )
     *         )
     *     ),
     * 
     *     @OA\Response(
     *         response=200,
     *         description="Course updated successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="title", type="string", example="Updated Laravel Course"),
     *             @OA\Property(property="description", type="string", example="Updated course description"),
     *             @OA\Property(
     *                 property="content",
     *                 type="array",
     *                 @OA\Items(
     *                     @OA\Property(property="title", type="string", example="Updated Chapter 1"),
     *                     @OA\Property(property="description", type="string", example="Updated Introduction"),
     *                     @OA\Property(
     *                         property="videos",
     *                         type="array",
     *                         @OA\Items(
     *                             @OA\Property(property="title", type="string", example="Updated Video 1"),
     *                             @OA\Property(property="description", type="string", example="Updated description for video 1"),
     *                             @OA\Property(property="url", type="string", example="https://www.youtube.com/embed/updated123")
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
     *         description="Forbidden - user lacks necessary role or permission",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="This action is unauthorized.")
     *         )
     *     ),
     * 
     *     @OA\Response(
     *         response=404,
     *         description="Course not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="No query results for model [App\\Models\\Course] 999.")
     *         )
     *     ),
     * 
     *     @OA\Response(
     *         response=422,
     *         description="Validation error",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="The given data was invalid."),
     *             @OA\Property(property="errors", type="object",
     *                 @OA\Property(property="title", type="array",
     *                     @OA\Items(type="string", example="The title field is required.")
     *                 ),
     *                 @OA\Property(property="content", type="array",
     *                     @OA\Items(type="string", example="The content must be an array.")
     *                 )
     *             )
     *         )
     *     )
     * )
     *
     * Headers para Postman:
     * - Accept: application/json
     * - Content-Type: application/json
     * - Authorization: Bearer {token}
     */


    public function update(CourseCreateRequest $request, Course $course)
    {
        $data = $request->validated();
    
        foreach ($data['content'] as &$chapter) {
            foreach ($chapter['videos'] as &$video) {
                $video['url'] = $this->convertToEmbedUrl($video['url']);
            }
        }
    
        $course->update($data);
    
        return response()->json($course, 200);
    }

        /**
     * @OA\Delete(
     *     path="/api/courses/{course}",
     *     summary="Delete a course",
     *     description="Allows an authenticated admin user to delete an existing course by its ID.",
     *     tags={"Courses"},
     *     security={{"passport": {}}},
     *
     *     @OA\Parameter(
     *         name="course",
     *         in="path",
     *         required=true,
     *         description="ID of the course to delete",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Course deleted successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Course deleted successfully")
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
     *         description="Forbidden - user lacks necessary role or permission",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="This action is unauthorized.")
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=404,
     *         description="Course not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="No query results for model [App\\Models\\Course] 999.")
     *         )
     *     )
     * )
     *
     * Headers para Postman:
     * - Accept: application/json
     * - Content-Type: application/json
     * - Authorization: Bearer {token}
     */


    public function destroy(Course $course)
    {
        $course->delete();
        return response()->json(['message' => 'Course deleted successfully'], 200);
    }

    private function convertToEmbedUrl($url)
    {
        // Extrae el ID del video
        if (preg_match('/(?:youtu\.be\/|youtube\.com\/(?:watch\?v=|embed\/|v\/))([\w\-]+)/', $url, $matches)) {
            return 'https://www.youtube.com/embed/' . $matches[1];
        }

        return $url; // Si no es una URL válida de YouTube, la deja tal cual
    }
}
