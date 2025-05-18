<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\HomeController;

Route::get('/', [HomeController::class, 'index']);

Route::resource('courses', CourseController::class);
Route::resource('lessons', LessonController::class);
