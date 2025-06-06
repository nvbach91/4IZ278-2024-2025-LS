<?php
// Model reprezentující lekci
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    protected $table = 'z_lessons'; // název tabulky

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

    // vazba na kurz
    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }

    public function homework()
    {
        return $this->hasOne(Homework::class, 'lesson_id');
    }

    public function submissions()
    {
        return $this->hasMany(Submission::class, 'id');
    }
}
