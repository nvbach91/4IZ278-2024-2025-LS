<?php

use App\Http\Controllers\CoachAuthController;   // ← přesný import
use App\Http\Controllers\CoachProfileController;   // pro update profilu
use App\Http\Controllers\CoachCourseController;
use App\Http\Controllers\CoachLessonController;

use App\Http\Controllers\StudentAuthController;
use App\Http\Controllers\StudentCourseController;
use App\Http\Controllers\StudentProfileController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'home');

/* ==================  COACH  ================== */
Route::prefix('coach')->name('coach.')->group(function () {

    // === Authentication (login/logout) ===
    Route::view('login', 'coach.auth.login')->name('login.show');
    Route::post('login', [CoachAuthController::class, 'login'])->name('login');

    // === Ochranná zóna pro přihlášené kouče ===
    Route::middleware('auth:coach')->group(function () {
        Route::post('logout', [CoachAuthController::class, 'logout'])->name('logout');
         // --- Dashboard (seznam kurzů, které kouč vyučuje) ---
        Route::get('dashboard', [CoachCourseController::class, 'index'])
            ->name('dashboard');

        // --- Create & Store ---
        Route::get('courses/create', [CoachCourseController::class, 'create'])
            ->name('courses.create');
        Route::post('courses', [CoachCourseController::class, 'store'])
            ->name('courses.store');

        // --- Manage / Detail kurzu ---
        Route::get('courses/{course}/manage', [CoachCourseController::class, 'manage'])
            ->name('courses.manage');

        // Open courses
        Route::get('open-courses', [CoachCourseController::class, 'openCourses'])
             ->name('open');


        // Edit course (zobrazení formuláře s hodnotami)
         Route::get('courses/{course}/edit', [CoachCourseController::class, 'edit'])
              ->name('courses.edit');

         // Update course (zpracování PUT/PATCH)
         Route::put('courses/{course}', [CoachCourseController::class, 'update'])
              ->name('courses.update');

         // Delete course
         Route::delete('courses/{course}', [CoachCourseController::class, 'destroy'])
              ->name('courses.destroy');

        // Lesson management – show, edit, update, and delete lessons
        Route::get('lessons/{lesson}', [CoachLessonController::class, 'show'])
            ->name('lessons.show');
        Route::get('lessons/{lesson}/edit', [CoachLessonController::class, 'edit'])
            ->name('lessons.edit');
        Route::put('lessons/{lesson}', [CoachLessonController::class, 'update'])
            ->name('lessons.update');
        Route::delete('lessons/{lesson}', [CoachLessonController::class, 'destroy'])
            ->name('lessons.destroy');

        // Grading homework submissions
        Route::put('submissions/{submission}/grade', [CoachLessonController::class, 'gradeSubmission'])
            ->name('submissions.grade');


        // Profile settings
        Route::get('profile', [CoachProfileController::class, 'show'])->name('profile');
        Route::put('profile', [CoachProfileController::class, 'update'])->name('profile.update');
    });
});


/* ==================  STUDENT  ================== */
Route::prefix('student')->name('student.')->group(function () {

    Route::middleware('guest:student')->group(function () {
        Route::view('login', 'student.auth.login')->name('login.show');
        Route::get('register', [StudentAuthController::class,'showRegister'])->name('register.show');
        Route::post('login',    [StudentAuthController::class,'login'])->name('login');
        Route::post('register', [StudentAuthController::class,'register'])->name('register');
        Route::get('student/login/google', [StudentAuthController::class, 'redirectToGoogle'])
            ->name('student.login.google');
        Route::get('student/login/google/callback', [StudentAuthController::class, 'handleGoogleCallback']);

    });

    Route::middleware('auth:student')->group(function () {
        Route::view('dashboard', 'student.dashboard')->name('dashboard');
        Route::post('logout', [StudentAuthController::class,'logout'])->name('logout');
        Route::get('dashboard', [StudentAuthController::class, 'dashboard'])
            ->name('dashboard');
        Route::get('open-courses', [StudentCourseController::class, 'index'])
            ->name('open');
        Route::post('courses/{course}/enroll', [StudentCourseController::class, 'enroll'])
            ->name('courses.enroll');
        Route::get('profile',  [StudentProfileController::class, 'show'])
            ->name('profile');
        Route::put('profile', [StudentProfileController::class, 'update'])
            ->name('profile.update');
        Route::delete('profile', [StudentProfileController::class, 'destroy'])
            ->name('profile.destroy');
    });
});
