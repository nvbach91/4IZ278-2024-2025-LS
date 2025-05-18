<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Models\Category;
use App\Models\Product;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CategoryController;

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

Route::get('/', function () {
    $categories = Category::all();
    $products = Product::all();
    return view('index')->with(['categories' => $categories, 'products' => $products]);
});
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/product/{id}', [ProductController::class, 'detail'])->name('products.detail');
Route::get('/profile/{id}', [UserController::class, 'profile']);
Route::get('/login', function () {
    return view('login');
});
Route::get('/register', function () {
    return view('register');
});
/*Route::get('/cart', function () {
    $categories = Category::all();
    return view('cart')->with(['categories' => $categories,]);
});*/

Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::get('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
Route::get('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
Route::get('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');

Route::get('/delivery-payment', [OrderController::class, 'index'])->name('delivery.payment');

Route::get('/delivery-details', [OrderController::class, 'deliveryDetails'])->name('delivery.details');

Route::get('/order-summary', [OrderController::class, 'orderSummary'])->name('order.summary');

Route::get('/admin-users', [UserController::class, 'adminUsers'])->name('admin.users');

Route::get('/admin-categories', [CategoryController::class, 'adminCategories'])->name('admin.categories');

Route::get('/admin-product/{id}', [ProductController::class, 'adminProduct'])->name('admin.product');

Route::get('/admin-orders', [OrderController::class, 'adminOrders'])->name('admin.orders');

//Route::get('/counter', CategoryList::class);
