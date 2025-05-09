<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TodoListController;

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
    // fetch db data
    $data = [
        'name' => 'David Beckham',
        'age' => 70,
    ];
    return view('welcome')->with($data);
});


Route::get('/products', function () {
    // fetch db data
    $items = [
        [
            'name' => 'BMW iX1',
            'price' => 70000,
        ],
        [
            'name' => 'Audi eTRON',
            'price' => 80000,
        ]
    ];
    return view('products')->with(['items' => $items]);
});




Route::post(
    '/todo',
    [TodoListController::class, 'saveTodo']
)->name('saveTodo');
