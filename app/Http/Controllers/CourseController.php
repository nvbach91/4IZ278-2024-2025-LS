<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use Carbon\Carbon;

class CourseController extends Controller
{
    /**
     * Zobrazí detail kurzu pro coache (správce kurzu).
     */
    public function show(Course $course)
    {
        // model Course má vztah students (many-to-many nebo hasMany)
        // a obsahuje sloupce registration_open, start_date, end_date...

        // pokud je potřeba, ověř že kurz patří coachovi:
        // if (auth()->id() !== $course->coach_id) {
        //     abort(403);
        // }

        // načíst i studenty
        $course->load('students');

        // datumy se upraví přes Carbon
        $nextSession = null;
        if ($course->next_session_date) {
            $nextSession = Carbon::parse($course->next_session_date)->format('j.n.Y');
        }

        return view('courses.show', [
            'course'       => $course,
            'nextSession'  => $nextSession,           // například 1/2/3456
            'startDate'    => Carbon::parse($course->start_date)->format('j.n.Y'),
            'endDate'      => Carbon::parse($course->end_date)->format('j.n.Y'),
            'registrationOpen' => (bool) $course->registration_open,
        ]);
    }
}
