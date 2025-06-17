<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\BusinessController;
use App\Http\Controllers\ReservationController;
use App\Models\Service;

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

Route::get('/confirm-overlay', function () {
    $type = request('type');

    if ($type === 'reservation') {
        $service = Service::findOrFail(request('service_id'));
        $date = request('date');
        $time = request('time');
        $slotId = request('slot_id');

        $details = view('partials.reservation-confirmation', compact('service', 'date', 'time'))->render();

        return view('partials.confirmation', [
            'title' => 'Potvrzení rezervace',
            'message' => 'Opravdu chcete potvrdit tuto rezervaci?',
            'details' => $details,
            'action' => route('reservation.confirm'),
            'method' => 'POST',
            'confirmText' => 'Potvrdit',
            'hidden' => [
                'service_id' => $service->id,
                'date' => $date,
                'time' => $time,
                'slot_id' => $slotId,
            ]
        ]);
    }


    // Default confirmation (e.g. delete)
    return view('partials.confirmation', [
        'title' => request('title'),
        'message' => request('message'),
        'action' => request('action'),
        'method' => request('method', 'POST'),
        'confirmText' => request('confirmText')
    ]);
})->name('overlay.confirm');

// USER - login
Route::get('/login', [UserController::class, 'showLoginForm'])->name('login.form');
Route::post('/login', [UserController::class, 'login'])->name('login');

// USER - register
Route::get('/register', [UserController::class, 'showRegisterForm'])->name('register.form');
Route::post('/register', [UserController::class, 'register'])->name('register');


Route::middleware(['auth'])->group(function () {


    Route::get('/logout', [UserController::class, 'logout'])->name('logout');

    Route::get('/user_profile', [UserController::class, 'showUserprofile'])->name('user.profile');
    Route::delete('/user_profile/delete', [UserController::class, 'destroy'])->name('profile.destroy');

    // BUSINESS

    Route::get('/business/create', [BusinessController::class, 'create'])->name('business.create');
    Route::post('/business', [BusinessController::class, 'store'])->name('business.store');
    Route::get('/business/{id}/edit', [BusinessController::class, 'edit'])->name('business.edit');
    Route::put('/business/{id}', [BusinessController::class, 'update'])->name('business.update');

    Route::get('/service/{id}', [ServiceController::class, 'index'])->name('service.show');
    Route::get('/business/service/{id}', [ServiceController::class, 'show'])->name('business.service');
    Route::post('/business/service/{id}/time', [ServiceController::class, 'saveTimeSlots'])->name('business.service.time');

    Route::delete('/business/service/{id}', [ServiceController::class, 'deleteTimeslots'])->name('business.service');
    Route::get('/service/{id}/available-dates', [ServiceController::class, 'availableDates'])->name('service.availableDates');


    Route::post('/reservation/confirm', [ReservationController::class, 'confirm'])->name('reservation.confirm');

    Route::get('/business/{id}/reservations', [ReservationController::class, 'index'])->name('business.reservations');
    Route::patch('/reservations/bulk-action', [ReservationController::class, 'bulkAction'])->name('reservation.bulkAction');


    Route::patch('/reservation/{id}/status', [ReservationController::class, 'updateStatus'])->name('reservation.updateStatus');
    Route::delete('/reservation/{id}', [ReservationController::class, 'destroy'])->name('reservation.destroy');


    Route::get('/reviews/create/{business_id}', [ReviewController::class, 'create'])->name('reviews.create');
    Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');
});






// Wildcards
Route::get('/business/{id}', [BusinessController::class, 'show'])->name('business.show');
