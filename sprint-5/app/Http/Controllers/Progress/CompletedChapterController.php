<?php

namespace App\Http\Controllers\Progress;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CompletedChapterController extends Controller
{
    public function __invoke(Request $request, $courseId, $chapterIndex)
    {
        $validated = validator(
            ['courseId' => $courseId, 'chapterIndex' => $chapterIndex],
            [
                'courseId' => 'required|integer|exists:courses,id',
                'chapterIndex' => 'required|integer|min:0',
            ]
        )->validate();
    
        // Aquí va la lógica de marcar capítulo como completado
    
        return response()->json([
            'message' => 'Chapter completed successfully.',
        ]);
    }
    

}
