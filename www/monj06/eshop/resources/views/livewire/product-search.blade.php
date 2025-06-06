<div>
    <input wire:model="search" type="search" placeholder="Hledat produkty">

    <ul class="mt-4">
        @forelse ($products as $product)
            <li>{{ $product->name }}</li>
        @empty
            <li>Žádné produkty nenalezeny.</li>
        @endforelse
    </ul>
</div>
