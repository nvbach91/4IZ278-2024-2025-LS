<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Submission extends Model
{
    protected $table = 'z_submissions';

    protected $fillable = ['homework_id', 'student_id', 'text', 'file_path', 'submitted_at', 'grade'];

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function homework()
    {
        return $this->belongsTo(Homework::class, 'homework_id');
    }
}
