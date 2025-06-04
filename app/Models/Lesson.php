<?php
// App\Models\Lesson.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    protected $table = 'z_lessons'; // nebo jak se jmenuje tabulka

    protected $fillable = [
        'course_id',
        'title',
        'description',
        'scheduled_at',
        'order_number',
    ];

    protected $casts = [
        'scheduled_at' => 'datetime',
    ];

    // Vztah na kurz
    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }

    public function homework()
    {
        return $this->hasOne(Homework::class, 'id');
    }

    public function submissions()
    {
        return $this->hasMany(Submission::class, 'id');
    }
}
