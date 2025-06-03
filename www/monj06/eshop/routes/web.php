<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Models\Category;
use App\Models\Product;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CategoryController;
use App\Livewire\ProductSearch;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/home', function () {
    $categories = Category::all();
    $products = Product::all();
    return view('index')->with(['categories' => $categories, 'products' => $products]);
})->name('index');

Route::get('/pokus', function () {
    return view('pokus');
})->name('pokus');

//NONauthenticated users
Route::middleware('guest')->controller(AuthController::class)->group(function () {
    Route::get('/login',  'showLogin')->name('show.login');
    Route::get('/register',  'showRegister')->name('show.register');
    Route::post('/login', 'login')->name('login');
    Route::post('/register', 'register')->name('register');
});
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

//authenticated users
Route::get('/profile/{id}', [UserController::class, 'profile'])->name('profile.index')->middleware('auth');

Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/product/{id}', [ProductController::class, 'detail'])->name('products.detail');

Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::get('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
Route::get('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
Route::get('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');

Route::get('/delivery-payment', [OrderController::class, 'index'])->name('delivery.payment');

Route::get('/delivery-details', [OrderController::class, 'deliveryDetails'])->name('delivery.details');

Route::get('/order-summary', [OrderController::class, 'orderSummary'])->name('order.summary');

Route::post('/place-order', [OrderController::class, 'store'])->name('order.store');

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin-orders', [OrderController::class, 'adminOrders'])->name('admin.orders');
    Route::get('/delete-order/{id}', [OrderController::class, 'deleteOrder'])->name('delete.order');
    Route::get('/update-order/{id}', [OrderController::class, 'updateOrder'])->name('update.order');
    Route::get('/delete-item-order/{id}', [OrderController::class, 'deleteItemOrder'])->name('delete.itemOrder');

    Route::get('/admin-users', [UserController::class, 'adminUsers'])->name('admin.users');
    Route::get('/delete-user/{id}', [UserController::class, 'deleteUser'])->name('delete.user');
    Route::get('/update-user/{id}', [UserController::class, 'updateUser'])->name('update.user');

    Route::get('/admin-categories', [CategoryController::class, 'adminCategories'])->name('admin.categories');
    Route::get('/delete-category/{id}', [CategoryController::class, 'deleteCategory'])->name('delete.category');
    Route::get('/update-category/{id}', [CategoryController::class, 'updateCategory'])->name('update.category');

    Route::get('/admin-product/{id}', [ProductController::class, 'adminProduct'])->name('admin.product');
    Route::get('/delete-product/{id}', [ProductController::class, 'deleteProduct'])->name('delete.product');
});
