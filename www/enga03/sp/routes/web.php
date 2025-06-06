<?php

use App\Http\Controllers\CoachAuthController;   // ← přesný import
use App\Http\Controllers\CoachProfileController;   // pro update profilu
use App\Http\Controllers\CoachCourseController;
use App\Http\Controllers\CoachLessonController;

use App\Http\Controllers\StudentAuthController;
use App\Http\Controllers\StudentCourseController;
use App\Http\Controllers\StudentLessonController;
use App\Http\Controllers\StudentProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\GoogleController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AdminController;

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

        // Lesson management – create, store, show, edit, update, and delete lessons
        Route::get('courses/{course}/lessons/create', [CoachLessonController::class, 'create'])
            ->name('lessons.create');
        Route::post('courses/{course}/lessons', [CoachLessonController::class, 'store'])
            ->name('lessons.store');
        Route::get('lessons/{lesson}', [CoachLessonController::class, 'show'])
            ->name('lessons.lesson-detail');
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


/* ==================  ADMIN  ================== */
Route::prefix('admin')->name('admin.')->group(function () {
    // Authentication
    Route::view('login', 'admin.auth.login')->name('login.show');
    Route::post('login', [AdminAuthController::class, 'login'])->name('login');

    Route::middleware('auth:admin')->group(function () {
        Route::post('logout', [AdminAuthController::class, 'logout'])->name('logout');
        Route::get('dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    });
});


/* ==================  STUDENT  ================== */
Route::prefix('student')->name('student.')->group(function () {

    Route::middleware('guest:student')->group(function () {
        Route::view('login', 'student.auth.login')->name('login.show');
        Route::get('register', [StudentAuthController::class,'showRegister'])->name('register.show');
        Route::post('login',    [StudentAuthController::class,'login'])->name('login');
        Route::post('register', [StudentAuthController::class,'register'])->name('register');

        Route::get('login/google', [GoogleController::class, 'redirectToGoogle'])
            ->name('login.google');

        Route::get('auth/google/callback', [GoogleController::class, 'handleGoogleCallback'])
            ->name('google.callback');


    });

    Route::middleware('auth:student')->group(function () {
        Route::get('dashboard', [StudentCourseController::class, 'index'])
            ->name('dashboard');
        Route::post('logout', [StudentAuthController::class,'logout'])->name('logout');
        Route::get('dashboard', [StudentAuthController::class, 'dashboard'])
            ->name('dashboard');
        Route::get('open-courses', [StudentCourseController::class, 'open'])
            ->name('open');
        Route::get('courses/{course}', [StudentCourseController::class, 'show'])
            ->name('courses.show');
        Route::get('lessons/{lesson}', [StudentLessonController::class, 'show'])
            ->name('lessons.show');
        Route::post('courses/{course}/enroll', [StudentCourseController::class, 'enroll'])
            ->name('courses.enroll');
        Route::delete('courses/{course}/enroll', [StudentCourseController::class, 'unenroll'])
            ->name('courses.unenroll');
        Route::get('profile',  [StudentProfileController::class, 'show'])
            ->name('profile');
        Route::put('profile', [StudentProfileController::class, 'update'])
            ->name('profile.update');
        Route::delete('profile', [StudentProfileController::class, 'destroy'])
            ->name('profile.destroy');

        Route::get('auth/google/callback', [GoogleController::class, 'handleGoogleCallback'])
            ->name('google.callback');
    });
});
