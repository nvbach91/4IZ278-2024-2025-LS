<?php

namespace App\Models;

use App\Models\Course;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Student extends Authenticatable
{
    use HasFactory;

    /** ← přidej toto */
    protected $table = 'z_students';

    protected $fillable = [
        'name',
        'email',
        'birth_year',
        'password',
        'profile_picture',
    ];

    /** Kurzy, do kterých je student přihlášen */
    public function courses(): BelongsToMany
    {
        return $this->belongsToMany(
            Course::class,     // cílový model
            'z_enrollments',     // pivot tabulka
            'student_id',      // FK na z_students
            'course_id'        // FK na courses
        )->withTimestamps();
    }
}
