<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lesson;

class CoachLessonController extends Controller
{
    /**
     * Zobrazí detail konkrétní lekce (pro kouče).
     */
    public function show(Lesson $lesson)
    {
        // Eager-load related models (homework, submissions with students)
        $lesson->load([
            'homework',
            'submissions.student',
        ]);

        return view('coach.lesson-detail', compact('lesson'));
    }

    /**
     * Show the form for editing a lesson.
     */
    public function edit(Lesson $lesson)
    {
        $coach = auth('coach')->user();
        if ($lesson->course->coach_id !== $coach->id) {
            abort(403);
        }

        return view('coach.lessons.edit', compact('lesson'));
    }

    /**
     * Update the given lesson.
     */
    public function update(Request $request, Lesson $lesson)
    {
        $coach = auth('coach')->user();
        if ($lesson->course->coach_id !== $coach->id) {
            abort(403);
        }

        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'scheduled_at' => ['nullable', 'date'],
        ]);

        $lesson->update($data);

        return redirect()
            ->route('coach.lessons.show', $lesson)
            ->with('success', 'Lesson updated.');
    }

    /**
     * Remove the specified lesson.
     */
    public function destroy(Lesson $lesson)
    {
        $coach = auth('coach')->user();
        if ($lesson->course->coach_id !== $coach->id) {
            abort(403);
        }
        $course = $lesson->course;
        $lesson->delete();

        return redirect()
            ->route('coach.courses.manage', $course)
            ->with('success', 'Lesson deleted.');
    }

    /**
     * Assign a grade to a submission.
     */
    public function gradeSubmission(Request $request, \App\Models\Submission $submission)
    {
        $coach = auth('coach')->user();
        $lesson = $submission->homework->lesson;
        if ($lesson->course->coach_id !== $coach->id) {
            abort(403);
        }

        $data = $request->validate([
            'grade' => ['required', 'integer', 'min:1', 'max:5'],
        ]);

        $submission->grade = $data['grade'];
        $submission->save();

        return back()->with('success', 'Grade saved.');
    }
}
