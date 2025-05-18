<?php

namespace App\Http\Controllers;

use App\Models\Course;

class HomeController extends Controller
{
    public function index()
{
    $courses = Course::with('lessons.homework')->get();
    return view('home', compact('courses'));
}
}

