<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lesson;
use App\Models\Submission;
use App\Models\Course;

class CoachLessonController extends Controller
{
    /**
     * Display the specified lesson.
     *
     * @param  \App\Models\Lesson  $lesson
     * @return \Illuminate\View\View
     */
    public function show(Lesson $lesson)
    {
        return view('coach.lessons.lesson-detail', compact('lesson'));
    }

    /**
     * Show the form for creating a new lesson for given course.
     */
    public function create(Course $course)
    {
        return view('coach.lessons.create', compact('course'));
    }

    /**
     * Store a newly created lesson.
     */
    public function store(Request $request, Course $course)
    {
        $data = $request->validate([
            'title'        => 'required|string|max:255',
            'description'  => 'nullable|string',
            'scheduled_at' => 'nullable|date',
        ]);

        $data['course_id'] = $course->id;

        // Determine order number for the new lesson
        $maxOrder = Lesson::where('course_id', $course->id)
            ->max('order_number');
        $data['order_number'] = $maxOrder ? $maxOrder + 1 : 1;

        Lesson::create($data);

        return redirect()->route('coach.courses.manage', $course)
            ->with('success', 'Lesson created successfully.');
    }

    /**
     * Show the form for editing the specified lesson.
     *
     * @param  \App\Models\Lesson  $lesson
     * @return \Illuminate\View\View
     */
    public function edit(Lesson $lesson)
    {
        return view('coach.lessons.edit', compact('lesson'));
    }

    /**
     * Update the specified lesson in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Lesson  $lesson
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Lesson $lesson)
    {
        $data = $request->validate([
            'title'        => 'required|string|max:255',
            'description'  => 'nullable|string',
            'scheduled_at' => 'nullable|date',
        ]);

        $lesson->update($data);

        return redirect()->route('coach.lessons.lesson-detail', $lesson)
            ->with('success', 'Lesson updated successfully.');
    }

    /**
     * Remove the specified lesson from storage.
     *
     * @param  \App\Models\Lesson  $lesson
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Lesson $lesson)
    {
        $lesson->delete();

        return redirect()->route('coach.dashboard')
            ->with('success', 'Lesson deleted successfully.');
    }

    /**
     * Grade a homework submission.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Submission  $submission
     * @return \Illuminate\Http\RedirectResponse
     */
    public function gradeSubmission(Request $request, Submission $submission)
    {
        $data = $request->validate([
            'grade' => 'required|numeric|min:0|max:100',
        ]);

        $submission->update([
            'grade' => $data['grade']
        ]);

        return redirect()->back()
            ->with('success', 'Submission graded successfully.');
    }
}
