@extends('components.layouts.admin-usersL')


@section('content')
    <!-- navbar LiveWire component -->
    <livewire:navbar :categories="$categories" />

    <flux:main container>
        <!-- cart LiveWire component -->
        <livewire:admin-users-component :users="$users" />
    </flux:main>
@endsection

@section('footer')
    <!-- footer LiveWire component -->
    <livewire:footer />
@endsection
