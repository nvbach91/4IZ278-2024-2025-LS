@extends('layouts.app')


@section('content')
    <div class="container">
        <h2>Vytvořit Business</h2>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('business.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="name" class="form-label">Název</label>
                <input type="text" name="name" id="name" class="form-control" required value="{{ old('name') }}">
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Popis</label>
                <textarea name="description" id="description" class="form-control">{{ old('description') }}</textarea>
            </div>

            <button type="submit" class="btn btn-primary">Vytvořit</button>
        </form>
    </div>
@endsection
