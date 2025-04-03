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
 *     summary="Marcar capítulo como completado",
 *     description="Permite a un usuario marcar un capítulo como completado y actualizar su progreso en el curso.",
 *     operationId="completeChapter",
 *     tags={"Progress"},
 *     security={{"passport":{}}},
 * 
 *     @OA\Parameter(
 *         name="courseId",
 *         in="path",
 *         description="ID del curso",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Parameter(
 *         name="chapterIndex",
 *         in="path",
 *         description="Índice del capítulo (comienza en 0)",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *
 *     @OA\Response(
 *         response=200,
 *         description="Capítulo completado correctamente",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="Chapter completed successfully."),
 *             @OA\Property(property="progress", type="integer", example=100)
 *         )
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Capítulo ya completado",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="Chapter already completed")
 *         )
 *     ),
 *     @OA\Response(
 *         response=403,
 *         description="Usuario no inscrito en el curso o sin rol adecuado",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="You are not enrolled in this course.")
 *         )
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Token ausente o inválido",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="Unauthenticated.")
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Curso no encontrado",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="No query results for model [App\\Models\\Course] 999")
 *         )
 *     )
 * )
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
    
        // 🏅 Lógica de medallas
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
