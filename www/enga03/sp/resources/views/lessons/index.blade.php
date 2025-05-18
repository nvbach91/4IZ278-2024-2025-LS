<h1>Lekce</h1>
<a href="{{ route('lessons.create') }}">Nová lekce</a>
<ul>
@foreach($lessons as $lesson)
    <li>{{ $lesson->title }} – (Course ID: {{ $lesson->course_id }})</li>
@endforeach
</ul>
