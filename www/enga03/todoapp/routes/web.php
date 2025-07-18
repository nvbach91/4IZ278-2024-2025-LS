<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TodoListController;
use App\Models\Todo;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/todos', function () {
    $todos = Todo::all();
    return view('todos')->with([ 'todos' => $todos ]);
});


Route::post('/todo', [TodoListController::class, 'saveTodo'])->name('saveTodo');
Route::delete('/todo/{id}', [TodoListController::class, 'deleteTodo'])->name('deleteTodo');
Route::put('/todo/{id}/finish', [TodoListController::class, 'finishTodo'])->name('finishTodo');
Route::put('/todo/{id}/unfinish', [TodoListController::class, 'unfinishTodo'])->name('unfinishTodo');