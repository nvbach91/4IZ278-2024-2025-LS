<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class StudentCourseController extends Controller
{
    /** Zobrazí seznam kurzů, do kterých student ještě není zapsán */
    public function index(Request $request)
    {
        $student = $request->user('student');

        // kurzy, které student nemá v pivotu z_enrollments
        $courses = Course::whereNotIn('id',
                        $student->courses()->pluck('z_courses.id'))
                   ->orderBy('name')
                   ->get();

        return view('student.open-courses', compact('courses'));
    }

    /** Zapíše studenta do vybraného kurzu */
    public function enroll(Request $request, Course $course)
    {
        $student = $request->user('student');

        if (! $student->courses()->whereKey($course->id)->exists()) {
            $student->courses()->attach($course->id);   // zapíše pivot z_enrollments
        }

        return back()->with('success',
            'Úspěšně zapsáno do kurzu „'.$course->name.'“.');
    }
}
