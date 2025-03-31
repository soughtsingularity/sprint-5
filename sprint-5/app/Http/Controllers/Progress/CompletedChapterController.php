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
            [
                'chapterIndex' => 'required|integer|min:0',
            ]
        )->validate();
        
        $course = Course::findOrFail($courseId);
        

        $user = auth()->user();
        $course = Course::findOrFail($courseId);
        $chapters = is_string($course->content)
        ? json_decode($course->content, true)
        : $course->content;
    
        if(!$user->courses()->where('course_id', $courseId)->exists()) {
            return response()->json([
                'message' => 'You are not enrolled in this course.',
            ], 403);
        }

        $currentProgress = $user->courses()->where('course_id', $courseId)->first()->pivot->progress ?? 0;
        $expectedProgress = round((($chapterIndex + 1) / count($chapters)) * 100);

        if ($currentProgress >= $expectedProgress) {
            return response()->json(['message' => 'Chapter already completed'], 400);
        }


    
        $totalChapters = count($chapters);
        $progress = round((($chapterIndex + 1) / $totalChapters) * 100);
    
        $user->courses()->updateExistingPivot($courseId, [
            'progress' => $progress,
        ]);
    
        return response()->json([
            'message' => 'Chapter completed successfully.',
            'progress' => $progress,
        ]);    
        return response()->json([
            'message' => 'Chapter completed successfully.',
        ]);
    }
    

}
