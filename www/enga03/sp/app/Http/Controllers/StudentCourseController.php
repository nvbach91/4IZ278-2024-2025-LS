<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Course;
use Carbon\Carbon;

class StudentCourseController extends Controller
{
    /**
     * Display the student dashboard with their enrolled courses.
     */
    public function index()
    {
        $student = auth()->guard('student')->user();
        $courses = $student->courses;

        return view('student.dashboard', compact('courses'));
    }

    /**
     * Show courses open for enrollment.
     */
    public function open()
    {
        $courses = Course::whereDate('start_date', '>', Carbon::today())->get();

        return view('student.open-courses', compact('courses'));
    }

    /**
     * Display the specified course with enrollment info.
     */
    public function show(Course $course)
    {
        $course->load('lessons');

        $student = auth()->guard('student')->user();
        $isEnrolled = $student->courses->contains($course->id);

        return view('student.courses.course-detail', compact('course', 'isEnrolled'));
    }

    /**
     * Enroll the current student in the given course.
     */
    public function enroll(Course $course)
    {
        $student = auth()->guard('student')->user();

        if ($course->start_date->isFuture()) {
            $student->courses()->syncWithoutDetaching([
                $course->id => ['enrolled_at' => now()]
            ]);
        }

        return back()->with('success', 'You have been enrolled in the course.');
    }

    /**
     * Unenroll the current student from the given course.
     */
    public function unenroll(Course $course)
    {
        $student = auth()->guard('student')->user();
        $student->courses()->detach($course->id);

        return back()->with('success', 'You have been unenrolled from the course.');
    }
}
