<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Support\Facades\Route;


class HomeController extends Controller
{
    public function index()
{
    $courses = Course::with('lessons.homework')->get();
    return view('home', compact('courses'));
}
}

