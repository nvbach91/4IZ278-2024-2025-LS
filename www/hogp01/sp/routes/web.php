<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\CheckoutController;

Route::get('/', function () {
    return view('homepage');
})->name('homepage');

// Product & Product detail
Route::get('/products/{gender?}/{category?}', [ShopController::class, 'index'])->name('products');
Route::get('/detail/{product}', [ShopController::class, 'detail'])->name('detail');

// Login
Route::post('/login', [LoginController::class, 'login'])->name('login');
Route::get('/login', function () {
    return view('login');
})->name('login');

// Register
Route::post('/register', [RegisterController::class, 'register'])->name('register');
Route::get('/register', function () {
    return view('register');
})->name('register');

//Logout
Route::get('/logout', function () {
    Auth::logout();
    return redirect('/login');
})->name('logout');

// Only for admins, catch all routes are used
Route::middleware(['auth', 'is_admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('products', ProductController::class);
    Route::resource('orders', OrderController::class);

});
// Only for logged in users
Route::middleware('auth')->group(function () {
    Route::put('/profile', [UserController::class, 'update'])->name('profile.update');
    Route::get('/profile', [UserController::class, 'index'])->name('profile.index');
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
    Route::post('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
    Route::post('/checkout', [CheckoutController::class, 'checkout'])->name('checkout');
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::get('/confirmation/{order}', [CheckoutController::class, 'confirmation'])->name('confirmation');
});
