@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto p-6">
    <h1 class="text-3xl font-bold mb-6">Vítej v CRM platformě!</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        @foreach ($courses as $course)
            <div class="bg-white shadow rounded-2xl p-4 border border-gray-200">
                <h2 class="text-xl font-semibold mb-2">{{ $course->name ?? 'Název kurzu' }}</h2>
                <p class="text-gray-600 mb-2">{{ $course->description ?? 'Popis není dostupný' }}</p>
                <p class="text-sm text-gray-500">Lekcí: {{ $course->lessons->count() }}</p>

                @php
                    $homeworkCount = $course->lessons->reduce(fn($carry, $lesson) => $carry + $lesson->homework->count(), 0);
                @endphp
                <p class="text-sm text-gray-500">Domácích úkolů: {{ $homeworkCount }}</p>

                <a href="{{ route('courses.index') }}" class="mt-4 inline-block text-indigo-600 hover:text-indigo-800 font-medium">Zobrazit všechny kurzy</a>
            </div>
        @endforeach
    </div>
</div>
@endsection
