<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\BusinessController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|


Route::get('/', function () {
    return view('home');
})->name('home');*/

Route::get('/', [BusinessController::class, 'home'])->name('home');

// USER - login
Route::get('/login', [UserController::class, 'showLoginForm'])->name('login.form');
Route::post('/login', [UserController::class, 'login'])->name('login');

// USER - register
Route::get('/register', [UserController::class, 'showRegisterForm'])->name('register.form');
Route::post('/register', [UserController::class, 'register'])->name('register');

Route::get('/logout', [UserController::class, 'logout'])->name('logout');

Route::get('/user_profile', [UserController::class, 'showUserprofile'])->name('user.profile');


// BUSINESS
Route::middleware(['auth'])->group(function () {
    Route::get('/business/create', [BusinessController::class, 'create'])->name('business.create');
    Route::post('/business', [BusinessController::class, 'store'])->name('business.store');
});






// Wildcards
Route::get('/business/{id}', [BusinessController::class, 'show'])->name('business.show');




