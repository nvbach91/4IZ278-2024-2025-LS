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
        // Přihlášený kouč (guard: coach)
        $coach = $request->user('coach');

        // Načteme všechny kurzy, kde coach_id = $coach->id
        $courses = $coach->courses()->get();

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
        // Ověříme, že kurz opravdu patří přihlášenému kouči (abezpečení):
        $coach = auth('coach')->user();
        if ($course->coach_id !== $coach->id) {
            abort(403);
        }

        // Vrať view s předvyplněnými hodnotami kurzu
        return view('coach.courses.edit', compact('course'));
    }

    /**
     * Zpracuje odeslaný formulář pro úpravu a uloží změny do DB.
     */
    public function update(Request $request, Course $course)
    {
        // Ověření vlastníka (jen kouč, který kurz vytvořil, může upravovat)
        $coach = auth('coach')->user();
        if ($course->coach_id !== $coach->id) {
            abort(403);
        }

        // Validace vstupních dat (podobná jako ve store())
        $data = $request->validate([
            'name'          => ['required', 'string', 'max:255'],
            'template_id'   => ['nullable', 'integer', 'exists:z_course_templates,id'],
            'start_date'    => ['nullable', 'date'],
            'end_date'      => ['nullable', 'date', 'after_or_equal:start_date'],
            'schedule_info' => ['nullable', 'string'],
        ]);

        // Aktualizace atributů
        $course->name          = $data['name'];
        $course->template_id   = $data['template_id'] ?? null;
        $course->start_date    = $data['start_date'] ?? null;
        $course->end_date      = $data['end_date'] ?? null;
        $course->schedule_info = $data['schedule_info'] ?? null;

        // Uložíme do DB (updated_at se vyplní automaticky)
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

        // Přihlášený kouč
        $coach = $request->user('coach');

        // Vložíme nový řádek do tabulky z_courses; timestamps (created_at/updated_at) Eloquent vyplní automaticky
        $course = Course::create([
            'name'          => $data['name'] ?? null,
            'template_id'   => $data['template_id'] ?? null,
            'coach_id'      => $coach->id,
            'start_date'    => $data['start_date'] ?? null,
            'end_date'      => $data['end_date'] ?? null,
            'schedule_info' => $data['schedule_info'] ?? null,
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
        // Nahrajeme k danému kurzu všechny lekce a studenty, aby byly k dispozici ve View
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
