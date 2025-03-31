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
            ['courseId' => $courseId, 'chapterIndex' => $chapterIndex],
            [
                'courseId' => 'required|integer|exists:courses,id',
                'chapterIndex' => 'required|integer|min:0',
            ]
        )->validate();

        $user = auth()->user();
        $course = Course::findOrFail($courseId);
        $chapters = json_decode($course->content, true);

        if(!$user->courses()->where('course_id', $courseId)->exists()) {
            return response()->json([
                'message' => 'You are not enrolled in this course.',
            ], 403);
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
