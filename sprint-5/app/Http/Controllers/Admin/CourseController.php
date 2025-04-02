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
 *     summary="Create a new course (Admin only)",
 *     tags={"Admin - Courses"},
 *     security={{"passport": {}}},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"title", "description", "content"},
 *             @OA\Property(property="title", type="string", example="New Course"),
 *             @OA\Property(property="description", type="string", example="This is a new course"),
 *             @OA\Property(
 *                 property="content",
 *                 type="array",
 *                 @OA\Items(
 *                     type="object",
 *                     @OA\Property(property="title", type="string", example="Capítulo 1"),
 *                     @OA\Property(property="description", type="string", example="Intro"),
 *                     @OA\Property(
 *                         property="videos",
 *                         type="array",
 *                         @OA\Items(
 *                             type="object",
 *                             @OA\Property(property="title", type="string", example="Video 1"),
 *                             @OA\Property(property="description", type="string", example="Descripción video 1"),
 *                             @OA\Property(property="url", type="string", format="url", example="https://www.youtube.com/watch?v=video1")
 *                         )
 *                     )
 *                 )
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=201,
 *         description="Course created successfully",
 *         @OA\JsonContent(
 *             @OA\Property(property="id", type="integer", example=1),
 *             @OA\Property(property="title", type="string", example="New Course"),
 *             @OA\Property(property="description", type="string", example="This is a new course"),
 *             @OA\Property(property="content", type="array", @OA\Items(type="object"))
 *         )
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Unauthorized – missing or invalid token",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="Unauthenticated.")
 *         )
 *     ),
 *     @OA\Response(
 *         response=403,
 *         description="Forbidden – user does not have admin role or permission",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="User does not have the right roles.")
 *         )
 *     ),
 *     @OA\Response(
 *         response=422,
 *         description="Validation error",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="The given data was invalid."),
 *             @OA\Property(
 *                 property="errors",
 *                 type="object",
 *                 example={
 *                     "title": {"The title field is required."}
 *                 }
 *             )
 *         )
 *     )
 * )
 */

    public function store(CourseCreateRequest $request)
    {
        $data = $request->validated();
    
        // Convertir URLs de YouTube a formato embed
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
 *     summary="Update an existing course (Admin only)",
 *     tags={"Admin - Courses"},
 *     security={{"passport": {}}},
 *     @OA\Parameter(
 *         name="course",
 *         in="path",
 *         required=true,
 *         description="ID of the course to update",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"title", "description", "content"},
 *             @OA\Property(property="title", type="string", example="Updated Course"),
 *             @OA\Property(property="description", type="string", example="Updated course description"),
 *             @OA\Property(
 *                 property="content",
 *                 type="array",
 *                 @OA\Items(
 *                     type="object",
 *                     @OA\Property(property="title", type="string", example="Updated Chapter 1"),
 *                     @OA\Property(property="description", type="string", example="Updated chapter description"),
 *                     @OA\Property(
 *                         property="videos",
 *                         type="array",
 *                         @OA\Items(
 *                             type="object",
 *                             @OA\Property(property="title", type="string", example="Video 1"),
 *                             @OA\Property(property="description", type="string", example="Updated video description"),
 *                             @OA\Property(property="url", type="string", format="url", example="https://www.youtube.com/watch?v=video1")
 *                         )
 *                     )
 *                 )
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Course updated successfully",
 *         @OA\JsonContent(
 *             @OA\Property(property="id", type="integer", example=1),
 *             @OA\Property(property="title", type="string", example="Updated Course"),
 *             @OA\Property(property="description", type="string", example="Updated course description"),
 *             @OA\Property(property="content", type="array", @OA\Items(type="object"))
 *         )
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Unauthorized – missing or invalid token",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="Unauthenticated.")
 *         )
 *     ),
 *     @OA\Response(
 *         response=403,
 *         description="Forbidden – user does not have admin role or permission",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="User does not have the right roles.")
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Course not found",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="No query results for model [App\\Models\\Course] 12")
 *         )
 *     ),
 *     @OA\Response(
 *         response=422,
 *         description="Validation error",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="The given data was invalid."),
 *             @OA\Property(
 *                 property="errors",
 *                 type="object",
 *                 example={
 *                     "content.0.videos.0.title": {
 *                         "The content.0.videos.0.title must be a string."
 *                     },
 *                     "content.0.videos.0.description": {
 *                         "The content.0.videos.0.description must be a string."
 *                     }
 *                 }
 *             )
 *         )
 *     )
 * )
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
 *     summary="Delete a course (Admin only)",
 *     tags={"Admin - Courses"},
 *     security={{"passport": {}}},
 *     @OA\Parameter(
 *         name="course",
 *         in="path",
 *         required=true,
 *         description="ID of the course to delete",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Course deleted successfully",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="Course deleted successfully")
 *         )
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Unauthorized – missing or invalid token",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="Unauthenticated.")
 *         )
 *     ),
 *     @OA\Response(
 *         response=403,
 *         description="Forbidden – user does not have admin role or permission",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="User does not have the right roles.")
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Course not found",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="No query results for model [App\\Models\\Course] 99")
 *         )
 *     )
 * )
 */

    private function convertToEmbedUrl($url)
    {
        // Extrae el ID del video
        if (preg_match('/(?:youtu\.be\/|youtube\.com\/(?:watch\?v=|embed\/|v\/))([\w\-]+)/', $url, $matches)) {
            return 'https://www.youtube.com/embed/' . $matches[1];
        }

        return $url; // Si no es una URL válida de YouTube, la deja tal cual
    }

    public function destroy(Course $course)
    {
        $course->delete();
        return response()->json(['message' => 'Course deleted successfully'], 200);
    }


}
