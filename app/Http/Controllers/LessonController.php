<?php

namespace App\Http\Controllers;
use App\Models\Lesson;
use Illuminate\Http\Request;

class LessonController extends Controller
{
   public function index()
{
    $lessons = Lesson::all();
    return view('lessons.index', compact('lessons'));
}

public function create()
{
    return view('lessons.create');
}

public function store(Request $request)
{
    $validated = $request->validate([
        'course_id' => 'required|integer',
        'title' => 'required|string|max:255',
        'content' => 'nullable|string',
    ]);

    Lesson::create($validated);
    return redirect()->route('lessons.index');
}
}
