@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<h2 class="mb-4">Coaches</h2>
<table class="table table-bordered mb-5">
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
        </tr>
    </thead>
    <tbody>
        @foreach($coaches as $coach)
        <tr>
            <td>{{ $coach->id }}</td>
            <td>{{ $coach->name }}</td>
            <td>{{ $coach->email }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

<h2 class="mb-4">Students</h2>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
        </tr>
    </thead>
    <tbody>
        @foreach($students as $student)
        <tr>
            <td>{{ $student->id }}</td>
            <td>{{ $student->name }}</td>
            <td>{{ $student->email }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
