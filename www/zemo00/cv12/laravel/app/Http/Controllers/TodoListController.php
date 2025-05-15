<?php
namespace  App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Todo;
use App\Http\Requests\TodoRequest;

class  TodoListController extends Controller {
	public function saveTodo(TodoRequest $request) {
	    $newTodo = new Todo();
	    $newTodo->title = $request->title;
	    $newTodo->finished = 0;
	    $newTodo->save();
	    return redirect('todo');
	}

	public function deleteTodo($id) {
    	Todo::where('id', $id)->delete();
    	return redirect('todo');
	}

	public function finishTodo($id) {
    	$todo = Todo::find($id);
    	$todo->finished = 1;
    	$todo->save();
    	return redirect('todo');
	}

	public function unfinishTodo($id) {
    	$todo = Todo::find($id);
    	$todo->finished = 0;
    	$todo->save();
    	return redirect('todo');
	}

}