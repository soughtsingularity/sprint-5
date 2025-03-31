<?php

namespace App\Http\Controllers\Progress;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CompletedChapterController extends Controller
{
    public function __invoke(Request $request, $courseId, $chapterIndex)
    {
        // Validate the request
        $request->validate([
            'courseId' => 'required|integer|exists:courses,id',
            'chapterIndex' => 'required|integer|min:0',
        ]);

        // Logic to mark the chapter as completed
        // ...

        return response()->json([
            'message' => 'Chapter completed successfully.',
        ]);
    }

}
