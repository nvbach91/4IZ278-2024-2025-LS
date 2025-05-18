<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $table = 'z_courses';
protected $fillable = ['template_id', 'coach_id', 'start_date', 'end_date', 'schedule_info'];

public function template()
{
    return $this->belongsTo(CourseTemplate::class, 'template_id');
}

public function coach()
{
    return $this->belongsTo(Coach::class, 'coach_id');
}

public function lessons()
{
    return $this->hasMany(Lesson::class, 'course_id');
}



}
