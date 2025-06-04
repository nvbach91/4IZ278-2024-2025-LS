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
        // Předpokládejme, že model Course má vztah "students" (many-to-many nebo hasMany)
        // a třeba sloupec "registration_open" (boolean), "start_date", "end_date" apod.

        // Pokud chceš ošetřit, že pouze coach, který vlastní kurz, ho vidí:
        // if (auth()->id() !== $course->coach_id) {
        //     abort(403);
        // }

        // Eager-load studenty
        $course->load('students');

        // Např. zařídit, aby se datumy formátovaly pomocí Carbonu
        $nextSession = null;
        if ($course->next_session_date) {
            $nextSession = Carbon::parse($course->next_session_date)->format('j.n.Y');
        }

        return view('courses.show', [
            'course'       => $course,
            'nextSession'  => $nextSession,           // např. 1/2/3456
            'startDate'    => Carbon::parse($course->start_date)->format('j.n.Y'),
            'endDate'      => Carbon::parse($course->end_date)->format('j.n.Y'),
            'registrationOpen' => (bool) $course->registration_open,
        ]);
    }
}
