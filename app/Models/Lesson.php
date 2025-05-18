<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    protected $table = 'z_lessons';

    protected $fillable = ['course_id', 'title', 'description', 'lesson_date', 'order_number'];

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }

    public function homework()
    {
        return $this->hasMany(Homework::class, 'lesson_id');
    }

    public function progress()
    {
        return $this->hasMany(Progress::class, 'lesson_id');
    }
}
