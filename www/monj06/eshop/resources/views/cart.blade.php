@extends('components.layouts.cartL')


@section('content')
    <!-- navbar LiveWire component -->
    <livewire:navbar :categories="$categories" />

    <flux:main container>
        <!-- cart LiveWire component -->
        <livewire:cart-component :cart="$cart" />
    </flux:main>
@endsection

@section('footer')
    <!-- footer LiveWire component -->
    <livewire:footer />
@endsection
