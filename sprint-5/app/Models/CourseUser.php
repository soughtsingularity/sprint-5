<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class CourseUser extends Pivot
{
    protected $table = 'course_user';

    protected $fillable = [
        'user_id',
        'course_id',
        'progress',
        'medal'
    ];

    protected $appends = [
        'computed_medal',
    ];

    public function getComputedMedalAttribute(): ?string
    {
        return match(true) {
            $this->progress >= 90 => 'gold',
            $this->progress >= 70 => 'silver',
            $this->progress >= 50 => 'bronze',
            default => null,
    }
}
