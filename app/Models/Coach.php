<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coach extends Model
{
    protected $table = 'z_coaches';

    protected $fillable = ['name', 'email', 'oauth_provider', 'profile_picture'];

    public function courses()
    {
        return $this->hasMany(Course::class, 'coach_id');
    }

    public function templates()
    {
        return $this->hasMany(CourseTemplate::class, 'coach_id');
    }
}

