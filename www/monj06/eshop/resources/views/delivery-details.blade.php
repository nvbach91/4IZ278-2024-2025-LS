@extends('components.layouts.cartL')


@section('content')
    <!-- navbar LiveWire component -->
    <livewire:navbar :categories="$categories" />

    <flux:main container>
        <!-- delivery payment LiveWire component -->
        <livewire:delivery-details-component :cart="$cart" />
    </flux:main>
@endsection

@section('footer')
    <!-- footer LiveWire component -->
    <livewire:footer />
@endsection
