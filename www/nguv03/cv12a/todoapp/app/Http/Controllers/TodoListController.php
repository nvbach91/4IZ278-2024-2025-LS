<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use App\Models\Todo;

class TodoListController extends Controller
{
    public function saveTodo(Request $request)
    {
        $newTodo = new Todo();
        $newTodo->title = $request->title;
        $newTodo->finished = 0;
        $newTodo->save();
        return redirect('todos');
    }
}
