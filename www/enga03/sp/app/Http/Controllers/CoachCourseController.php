<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;

class CoachCourseController extends Controller
{
    /**
     * Zobrazí seznam kurzů, které daný kouč vyučuje.
     */
    public function index(Request $request)
    {
        // přihlášený coach
        $coach = $request->user('coach');

        // vezmeme kurzy patřící tomuto kouči
        $courses = $coach->courses()->paginate(5);

        return view('coach.dashboard', compact('courses'));
    }

    /**
     * Zobrazí formulář pro vytvoření nového kurzu.
     */
    public function create()
    {
        return view('coach.courses.create');
    }

    public function edit(Course $course)
    {
        // kontrola, že kurz je fakt jeho
        $coach = auth('coach')->user();
        if ($course->coach_id !== $coach->id) {
            abort(403);
        }

        // prostě zobraz formulář s daty
        return view('coach.courses.edit', compact('course'));
    }

    /**
     * Zpracuje odeslaný formulář pro úpravu a uloží změny do DB.
     */
    public function update(Request $request, Course $course)
    {
        // jen autor kurzu ho může měnit
        $coach = auth('coach')->user();
        if ($course->coach_id !== $coach->id) {
            abort(403);
        }

        // ověření dat, skoro jak v store
        $data = $request->validate([
            'name'          => ['required', 'string', 'max:255'],
            'template_id'   => ['nullable', 'integer', 'exists:z_course_templates,id'],
            'start_date'    => ['nullable', 'date'],
            'end_date'      => ['nullable', 'date', 'after_or_equal:start_date'],
            'schedule_info' => ['nullable', 'string'],
        ]);

        // změna hodnot
        $course->name          = $data['name'];
        $course->template_id   = $data['template_id'] ?? null;
        $course->start_date    = $data['start_date'] ?? null;
        $course->end_date      = $data['end_date'] ?? null;
        $course->schedule_info = $data['schedule_info'] ?? null;

        // uložit, o čas se stará Eloquent
        $course->save();

        return redirect()
            ->route('coach.courses.manage', $course)
            ->with('success', 'Kurz byl úspěšně upraven.');
    }

    /**
     * Zpracuje odeslaný formulář a uloží nový kurz.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'          => ['required', 'string', 'max:255'],
            'template_id'   => ['nullable', 'integer', 'exists:z_course_templates,id'],
            'start_date'    => ['nullable', 'date'],
            'end_date'      => ['nullable', 'date', 'after_or_equal:start_date'],
            'schedule_info' => ['nullable', 'string'],
        ]);

        // aktuálně přihlášený kouč
        $coach = $request->user('coach');

        // do z_courses přidáme nový řádek, časy doplní Eloquent
        $course = Course::create([
            'name'          => $data['name'] ?? null,
            'template_id'   => $data['template_id'] ?? null,
            'coach_id'      => $coach->id,
            'start_date'    => $data['start_date'] ?? null,
            'end_date'      => $data['end_date'] ?? null,
            'schedule_info' => $data['schedule_info'] ?? null,
            'description' => $data['description'] ?? null,
        ]);

        return redirect()
            ->route('coach.courses.manage', $course)
            ->with('success', 'Kurz úspěšně vytvořen.');
    }

    /**
     * Zobrazí detail/správu jednoho kurzu.
     */
    public function manage(Course $course)
    {
        // načteme lekce i studenty, ať je to ve view
        $course->load(['lessons', 'students']);

        return view('coach.courses.course-detail', compact('course'));
    }

    /**
     * Delete the given course.
     */
    public function destroy(Course $course)
    {
        $coach = auth('coach')->user();
        if ($course->coach_id !== $coach->id) {
            abort(403);
        }

        $course->delete();

        return redirect()
            ->route('coach.dashboard')
            ->with('success', 'Course deleted.');
    }
}
