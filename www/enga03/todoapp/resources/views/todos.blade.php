<h1>Todo list</h1>

{{-- FORMULÁŘ PRO PŘIDÁNÍ NOVÉ POLOŽKY --}}
<form method="POST" action="{{ route('saveTodo') }}" style="margin-bottom: 1.5em; display: flex; gap: 0.5em;">
    @csrf
    <input 
        type="text" 
        name="title" 
        placeholder="Zadej název úkolu" 
        style="flex: 1; padding: 0.5em; border: 1px solid #ccc; border-radius: 4px;"
    >
    <button type="submit" style="padding: 0.5em 1em; border:none; background:#007bff; color:white; border-radius:4px;">
        Přidat
    </button>
</form>

@if ($errors->has('title'))
    <p style="color:red">{{ $errors->first('title') }}</p>
@endif

<ul style="list-style: none; padding: 0;">
    @foreach ($todos as $todo)
        <li style="margin-bottom: 1em;">
            {{-- zvýraznění zeleně, pokud je finished --}}
            <div 
                style="
                    padding: 0.75em; 
                    border-radius: 4px;
                    background-color: {{ $todo->finished ? '#d4edda' : '#f8f9fa' }};
                    border: 1px solid {{ $todo->finished ? '#c3e6cb' : '#ddd' }};
                    display: flex;
                    justify-content: space-between;
                    align-items: center;
                "
            >
                <span>{{ $todo->id }}. {{ $todo->title }}</span>

                <div style="display: flex; gap: 0.5em;">
                    {{-- Smazat --}}
                    <form method="POST" action="{{ route('deleteTodo', $todo->id) }}">
                        @csrf @method('DELETE')
                        <button type="submit" style="padding: 0.25em 0.5em; border:none; background:#dc3545; color:white; border-radius:4px;">
                            Delete
                        </button>
                    </form>

                    {{-- Dokončit / Vrátit --}}
                    @if($todo->finished)
                        <form method="POST" action="{{ route('unfinishTodo', $todo->id) }}">
                            @csrf @method('PUT')
                            <button type="submit" style="padding: 0.25em 0.5em; border:none; background:#17a2b8; color:white; border-radius:4px;">
                                Unfinish
                            </button>
                        </form>
                    @else
                        <form method="POST" action="{{ route('finishTodo', $todo->id) }}">
                            @csrf @method('PUT')
                            <button type="submit" style="padding: 0.25em 0.5em; border:none; background:#28a745; color:white; border-radius:4px;">
                                Finish
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </li>
    @endforeach
</ul>
