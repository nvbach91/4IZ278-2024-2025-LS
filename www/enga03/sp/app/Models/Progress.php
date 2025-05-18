<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Progress extends Model
{
    protected $table = 'z_progress';

    protected $fillable = ['student_id', 'lesson_id', 'completed_at'];

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function lesson()
    {
        return $this->belongsTo(Lesson::class, 'lesson_id');
    }
}
