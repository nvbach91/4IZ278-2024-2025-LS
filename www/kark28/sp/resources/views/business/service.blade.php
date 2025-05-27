@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="w-100 px-3 mt-3">
            <a href="{{ url()->previous() }}" class="btn btn-link text-decoration-none">
                <i class="fas fa-chevron-left"></i> Zpět
            </a>
        </div>

        <h1>Definovat čas pro službu: {{ $service->name }}</h1>

        <form action="{{ route('business.service.time', $service->id) }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="date_from">Datum od:</label>
                <input type="date" name="date_from" id="date_from" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="date_to">Datum do:</label>
                <input type="date" name="date_to" id="date_to" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="time_from">Čas od:</label>
                <input type="time" name="time_from" id="time_from" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="time_to">Čas do:</label>
                <input type="time" name="time_to" id="time_to" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-success mt-3">Přidat čas</button>
        </form>
    </div>
@endsection
