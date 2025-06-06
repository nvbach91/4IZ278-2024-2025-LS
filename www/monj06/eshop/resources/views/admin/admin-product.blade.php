@extends('components.layouts.admin-usersL')


@section('content')
    <!-- navbar LiveWire component -->
    <livewire:navbar :categories="$categories" />

    <flux:main container>
        <!-- cart LiveWire component -->
        <livewire:admin-product-component :product="$product" />
    </flux:main>
@endsection

@section('footer')
    <!-- footer LiveWire component -->
    <livewire:footer :categories="$categories" />
@endsection
