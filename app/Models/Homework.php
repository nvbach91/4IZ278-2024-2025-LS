<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Homework extends Model
{
    protected $table = 'z_homework';

    protected $fillable = [
        'lesson_id', 'title', 'description', 'open_at', 'due_at'
    ];

    public function lesson()
    {
        return $this->belongsTo(Lesson::class, 'lesson_id');
    }

    public function submissions()
    {
        return $this->hasMany(Submission::class, 'homework_id');
    }
}

