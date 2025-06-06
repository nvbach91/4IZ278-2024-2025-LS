<?php

use Illuminate\Support\Facades\Route;

// např. routes/coach.php
Route::middleware('auth:coach')->group(function () {
    Route::view('dashboard','coach.dashboard');
});

