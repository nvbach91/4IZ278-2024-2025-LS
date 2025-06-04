{{-- resources/views/courses/show.blade.php --}}
@extends('layouts.coach')

@section('content')
    {{-- Hlavní nadpis --}}
    <h1 class="h3 mb-4">{{ $course->name }}</h1>

    <div class="vstack gap-4">
        {{-- Panel s daty kurzu --}}
        <div class="card p-4">
            {{-- Další termín, Stav registrace, Datum startu a konce --}}
            <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between mb-3">
                <div class="d-flex align-items-center mb-2 mb-md-0">
                    @if($nextSession)
                        <span class="badge bg-info me-3">
                            Další termín: <strong>{{ $nextSession }}</strong>
                        </span>
                    @endif

                    @if($registrationOpen)
                        <span class="badge bg-success">Registrace otevřená</span>
                    @else
                        <span class="badge bg-danger">Registrace uzavřená</span>
                    @endif
                </div>

                <div class="text-muted">
                    Začátek / konec: <strong>{{ $startDate }} &ndash; {{ $endDate }}</strong>
                </div>
            </div>

            {{-- Popis kurzu --}}
            <div>
                {!! nl2br(e($course->description)) !!}
            </div>
        </div>

        {{-- Seznam studentů --}}
        <div class="card p-4">
            <h2 class="h5 mb-3">Studenti přihlášení do kurzu</h2>

            @if($course->students->isEmpty())
                <div class="text-muted">Žádní studenti zatím přihlášeni.</div>
            @else
                <ul class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-3 list-unstyled">
                    @foreach($course->students as $student)
                        <li class="col">
                            <div class="border rounded p-3 h-100 d-flex align-items-center gap-2">
                            {{-- Kolečko–ikona místo radio (můžeš to upravit podle potřeby) --}}
                            <svg xmlns="http://www.w3.org/2000/svg"
                                 class="h-5 w-5 text-gray-500"
                                 fill="none" viewBox="0 0 24 24"
                                 stroke="currentColor">
                                <circle cx="12" cy="12" r="10" stroke-width="2"></circle>
                                <circle cx="12" cy="12" r="5" fill="currentColor"></circle>
                            </svg>
                                <span class="fw-medium">{{ $student->name }}</span>
                            </div>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>

        {{-- Akční tlačítka --}}
        <div class="d-flex flex-wrap gap-2">
            {{-- Spravovat studenty --}}
            <a href="{{ route('courses.students.manage', $course->id) }}" class="btn btn-outline-secondary btn-sm">
                Spravovat studenty
            </a>

            {{-- Otevřít/Uzavřít registraci --}}
            <form action="{{ route('courses.toggleRegistration', $course->id) }}" method="POST" class="inline-block">
                @csrf
                <button type="submit" class="btn btn-sm {{ $registrationOpen ? 'btn-warning' : 'btn-success' }}">
                    {{ $registrationOpen ? 'Uzavřít registraci' : 'Otevřít registraci' }}
                </button>
            </form>

            {{-- Editovat kurz --}}
            <a href="{{ route('courses.edit', $course->id) }}" class="btn btn-sm btn-primary">
                Editovat kurz
            </a>

            {{-- Smazat kurz --}}
            <form action="{{ route('courses.destroy', $course->id) }}" method="POST"
                  onsubmit="return confirm('Opravdu chcete smazat tento kurz?');" class="inline-block">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-sm btn-danger">
                    Smazat kurz
                </button>
            </form>

            {{-- Přidat domácí úkol --}}
            <a href="{{ route('homeworks.create', ['course' => $course->id]) }}" class="btn btn-sm btn-info">
                Přidat domácí úkol
            </a>

            {{-- Otevřít seznam lekcí --}}
            <a href="{{ route('courses.lessons.index', $course->id) }}" class="btn btn-sm btn-secondary">
                Otevřít seznam lekcí
            </a>
        </div>
    </div>
@endsection
