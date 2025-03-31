<?php

namespace App\Http\Controllers\Progress;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;

class CompletedChapterController extends Controller
{
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
        $chapters = json_decode($course->content, true);

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
