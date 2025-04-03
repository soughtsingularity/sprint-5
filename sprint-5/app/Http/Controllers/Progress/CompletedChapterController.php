<?php

namespace App\Http\Controllers\Progress;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;

class CompletedChapterController extends Controller
{

        /**
     * @OA\Post(
     *     path="/api/courses/{courseId}/chapters/{chapterIndex}/complete",
     *     summary="Mark chapter as completed",
     *     description="Marks a chapter as completed for the authenticated user. Updates the user's progress and assigns a medal based on the percentage of completion. Requires the user to be enrolled in the course.",
     *     tags={"Progress"},
     *     security={{"passport": {}}},
     *
     *     @OA\Parameter(
     *         name="courseId",
     *         in="path",
     *         required=true,
     *         description="ID of the course",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Parameter(
     *         name="chapterIndex",
     *         in="path",
     *         required=true,
     *         description="Index of the chapter to complete (starting from 0)",
     *         @OA\Schema(type="integer", example=0)
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Chapter marked as completed",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Chapter completed successfully."),
     *             @OA\Property(property="progress", type="integer", example=100),
     *             @OA\Property(property="completed_chapters", type="array", @OA\Items(type="integer")),
     *             @OA\Property(property="medal", type="string", example="gold")
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=400,
     *         description="Chapter already completed",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Chapter already completed")
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
     *         description="Forbidden - user not enrolled in the course or lacks 'user' role",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="You are not enrolled in this course.")
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=404,
     *         description="Course not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="No query results for model [App\\Models\\Course] 999")
     *         )
     *     )
     * )
     *
     * Headers para Postman:
     * - Accept: application/json
     * - Content-Type: application/json
     * - Authorization: Bearer {token}
     */



    public function __invoke(Request $request, $courseId, $chapterIndex)
    {
        $validated = validator(
            ['chapterIndex' => $chapterIndex],
            ['chapterIndex' => 'required|integer|min:0']
        )->validate();
    
        $user = auth()->user();
        $course = Course::findOrFail($courseId);
    
        if (!$user->courses()->where('course_id', $courseId)->exists()) {
            return response()->json(['message' => 'You are not enrolled in this course.'], 403);
        }
    
        $chapters = is_string($course->content)
            ? json_decode($course->content, true)
            : $course->content;
    
        $pivot = $user->courses()->where('course_id', $courseId)->first()->pivot;
    
        $completedChapters = $pivot->completed_chapters ?? [];
    
        if (!is_array($completedChapters)) {
            $completedChapters = json_decode($completedChapters, true) ?? [];
        }
    
        $chapterIndex = (int) $chapterIndex;
    
        if (in_array($chapterIndex, $completedChapters)) {
            return response()->json(['message' => 'Chapter already completed'], 400);
        }
    
        $completedChapters[] = $chapterIndex;
        $completedChapters = array_unique($completedChapters);
        sort($completedChapters);
    
        $total = count($chapters);
        $progress = $total > 0 ? round((count($completedChapters) / $total) * 100) : 0;
    
        $medal = null;
        if ($progress >= 90) $medal = 'gold';
        elseif ($progress >= 50) $medal = 'silver';
        elseif ($progress >= 30) $medal = 'bronze';
    
        $user->courses()->updateExistingPivot($courseId, [
            'progress' => $progress,
            'completed_chapters' => json_encode($completedChapters),
            'medal' => $medal,
        ]);
    
        return response()->json([
            'message' => 'Chapter completed successfully.',
            'progress' => $progress,
            'completed_chapters' => $completedChapters,
            'medal' => $medal,
        ]);
    }
}
