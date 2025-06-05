<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todo list</title>
    <style>
        li {
            list-style: none;
            margin-bottom: 10px;
        }

        .todo-item {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .todo-item form {
            display: inline;
            margin: 0;
        }

        .todo-item button {
            margin-left: 5px;
        }
    </style>
</head>
<body>
    <h1>My todo list</h1>
    <form method="POST" action="{{ route('saveTodo') }}">
        @csrf
        <input placeholder="title" name="title">
        <button>Submit</button>
    </form>

    @if($errors->has('title'))
        <p style="background-color: red">{{ $errors->first('title') }}</p>
    @endif

    <ul>
    @foreach ($todos as $todo)
        <li>
            <div class="todo-item">
                <form method="POST" action="{{ route('deleteTodo', $todo->id) }}">
                    @csrf @method('DELETE')
                    <button>Delete</button>
                </form>

                <div>{{ $todo->id }} {{ $todo->title }}</div>

                @if($todo->finished == 1)
                    <form method="POST" action="{{ route('unfinishTodo', $todo->id) }}">
                        @csrf @method('PUT')
                        <button>Unfinish</button>
                    </form>
                @else
                    <form method="POST" action="{{ route('finishTodo', $todo->id) }}">
                        @csrf @method('PUT')
                        <button>Finish</button>
                    </form>
                @endif
            </div>
        </li>
    @endforeach
    </ul>
</body>
</html>