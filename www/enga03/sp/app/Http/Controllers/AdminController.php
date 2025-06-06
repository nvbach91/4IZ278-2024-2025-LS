<?php

namespace App\Http\Controllers;

use App\Models\Coach;
use App\Models\Student;

class AdminController extends Controller
{
    public function dashboard()
    {
        $coaches = Coach::all();
        $students = Student::all();
        return view('admin.dashboard', compact('coaches', 'students'));
    }
}
