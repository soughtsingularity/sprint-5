<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;

class FullCourseResource extends JsonResource
{
    public function toArray($request)
    {
        $user = $this->additional['auth_user'] ?? auth()->user();
        
        $pivot = null;
        $progress = null;
        $completed = [];
        $medal = null;
        $isEnrolled = false;
    
        if ($user) {
            $pivot = DB::table('course_user')
                ->where('user_id', $user->id)
                ->where('course_id', $this->id)
                ->first();
    
            if ($pivot) {
                $progress = $pivot->progress ?? 0;
                $completed = json_decode($pivot->completed_chapters ?? '[]');
                $medal = $pivot->medal ?? null;
                $isEnrolled = true;
            }
        }
    
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'content' => $this->content,
            'users' => $this->whenLoaded('users'),
            'progress' => $progress,
            'completed' => $completed,
            'medal' => $medal,
            'is_enrolled' => $isEnrolled,
        ];
    }
    
}

