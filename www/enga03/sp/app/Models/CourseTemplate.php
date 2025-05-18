<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourseTemplate extends Model
{
    protected $table = 'z_course_templates';

    protected $fillable = ['title', 'description', 'coach_id'];

    public function coach()
    {
        return $this->belongsTo(Coach::class, 'coach_id');
    }

    public function courses()
    {
        return $this->hasMany(Course::class, 'template_id');
    }
}

