<h1>Seznam kurzů</h1>
<a href="{{ route('courses.create') }}">Nový kurz</a>
<ul>
@foreach($courses as $course)
    <li>{{ $course->name }} – {{ $course->description }}</li>
@endforeach
</ul>
