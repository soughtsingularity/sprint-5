<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'content'
    ];

    protected $casts = [
        'content' => 'array'
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'course_user', 'course_id', 'user_id')
                    ->using(CourseUser::class)
                    ->withPivot('progress', 'medal')
                    ->withTimestamps();
    }
}
