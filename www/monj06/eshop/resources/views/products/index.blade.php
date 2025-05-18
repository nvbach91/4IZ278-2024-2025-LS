@extends('components.layouts.app')



@section('navbar')
    @foreach ($categories as $category)
        <flux:navlist.item href="#">{{ $category->name }}</flux:navlist.item>
    @endforeach
@endsection

@section('content')
    @foreach ($products as $product)
        <!-- Products grid -->
        <div>
            <div
                class="bg-white rounded-lg shadow-card overflow-hidden transition-all duration-300 hover:-translate-y-1 hover:shadow-elevated">
                <a href="" data-navlink class="block">
                    <div class="relative aspect-[4/3] overflow-hidden bg-neutral-100">
                        <img src="{{ $product->image }}" alt="{{ $product->name }}"
                            class="w-full h-full object-cover transition-transform duration-300 hover:scale-105" />
                    </div>
                    <div class="p-4">
                        <h3 class="text-lg font-semibold text-neutral-800 mb-2 line-clamp-2">{{ $product->name }}</h3>
                        <div class="flex items-baseline mb-1">
                            <span class="text-lg font-bold text-primary-500">{{ $product->price }}</span>
                        </div>
                        <div class="text-sm text-neutral-500 line-clamp-2 mb-3">{{ $product->description }}</div>
                    </div>
                </a>
                <div class="px-4 pb-4">
                    <a href="{{ route('cart.add', $product->id) }}"
                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Add
                        to cart</a>
                </div>
            </div>
        </div>
    @endforeach
@endsection
