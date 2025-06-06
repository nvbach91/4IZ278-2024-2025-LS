@extends('components.layouts.cartL')


@section('content')
    <!-- navbar LiveWire component -->
    <livewire:navbar :categories="$categories" />

    <flux:main container>
        <!-- order summary LiveWire component -->
        <livewire:order-summary-component :cart="$cart" :deliverData="$deliverData" />
    </flux:main>
@endsection

@section('footer')
    <!-- footer LiveWire component -->
    <livewire:footer :categories="$categories" />
@endsection
