<?php

namespace App\Http\Controllers;

use App\Models\Lesson;

class StudentLessonController extends Controller
{
    /**
     * Display the specified lesson.
     */
    public function show(Lesson $lesson)
    {
        return view('student.lessons.lesson-detail', compact('lesson'));
    }
}
