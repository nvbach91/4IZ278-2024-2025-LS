@if (count($cart) == 0)
    <div class="bg-white rounded-lg shadow-lg p-8 text-center">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-20 w-20 mx-auto text-neutral-400 mb-4" fill="none"
            viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
        </svg>
        <h2 class="text-2xl font-semibold mb-4">Košík je prázdný</h2>
        <p class="text-neutral-600 mb-8">Přidejte si nějaké zboží do košíku.</p>
        <a href="{{ route('products.index') }}" data-navlink
            class="inline-flex items-center bg-blue-700 hover:bg-primary-600 text-white px-6 py-3 rounded-lg font-medium transition-colors">
            Začít nakupovat
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd"
                    d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z"
                    clip-rule="evenodd" />
            </svg>
        </a>
    </div>
@else
    <div class="flex flex-col lg:flex-row gap-8">
        <!-- Cart Items -->
        <div class="lg:w-2/3">
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <table class="min-w-full divide-y divide-neutral-200">
                    <thead class="bg-neutral-50">
                        <tr>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider">
                                Product
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-center text-xs font-medium text-neutral-500 uppercase tracking-wider">
                                Quantity
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-right text-xs font-medium text-neutral-500 uppercase tracking-wider">
                                Price
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-right text-xs font-medium text-neutral-500 uppercase tracking-wider">
                                Total
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-right text-xs font-medium text-neutral-500 uppercase tracking-wider">
                                <span class="sr-only">Actions</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-neutral-200">
                        @foreach ($cart as $id => $item)
                            <tr class="cart-item" data-product-id="{{ $id }}">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="h-16 w-16 flex-shrink-0 rounded overflow-hidden bg-neutral-100">
                                            <img class="h-full w-full object-cover" src="{{ $item['image'] }}"
                                                alt="{{ $item['name'] }}">
                                        </div>
                                        <div class="ml-4">
                                            <a href="" data-navlink
                                                class="text-sm font-medium text-neutral-900 hover:text-primary-500">
                                                {{ $item['name'] }}
                                            </a>
                                            <div class="text-sm text-neutral-500">
                                                Category: {{ $item['category'] }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center justify-center">
                                        <button
                                            class="decrease-quantity border border-neutral-300 rounded-l px-2 py-1 bg-neutral-100 hover:bg-neutral-200 transition-colors">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M20 12H4" />
                                            </svg>
                                        </button>
                                        <input type="number" min="1" max="{{ $item['stock'] }}"
                                            value="{{ $item['quantity'] }}"
                                            class="item-quantity w-12 text-center border-y border-neutral-300 py-1 focus:outline-none focus:ring-1 focus:ring-primary-500" />
                                        <button
                                            class="increase-quantity border border-neutral-300 rounded-r px-2 py-1 bg-neutral-100 hover:bg-neutral-200 transition-colors">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 4v16m8-8H4" />
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
                                    <div class="font-medium">{{ $item['price'] }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium item-total">
                                    {{ (int) $item['price'] * $item['quantity'] }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <a href="{{ route('cart.remove', $id) }}"
                                        class="remove-item text-red-500 hover:text-red-700">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                            fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="flex items-center justify-between mt-6">
                <a href="{{ route('products.index') }}"
                    class="inline-flex items-center text-primary-500 hover:text-primary-700 font-medium">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20"
                        fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z"
                            clip-rule="evenodd" />
                    </svg>
                    Continue Shopping
                </a>

                <a id="clear-cart" href="{{ route('cart.clear') }}"
                    class="inline-flex items-center text-neutral-500 hover:text-neutral-700 font-medium">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20"
                        fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                            clip-rule="evenodd" />
                    </svg>
                    Clear Cart
                </a>
            </div>
        </div>

        <!-- Order Summary -->
        <div class="lg:w-1/3">
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h2 class="text-xl font-semibold mb-4">Order Summary</h2>

                <div class="space-y-4 mb-6">
                    <div class="flex justify-between text-neutral-700">
                        <span>Mezisoučet</span>
                        <span>{{ number_format($subtotal, 2) }} Kč</span>
                    </div>
                    <div class="flex justify-between text-neutral-700">
                        <span>Doručení</span>
                        <span id="cart-shipping">0 Kč</span>
                    </div>
                    <div class="flex justify-between font-bold text-neutral-900 pt-4 border-t border-neutral-200">
                        <span>Celkem</span>
                        <span id="cart-total">{{ $total }} Kč</span>
                    </div>
                </div>

                <div class="space-y-3">
                    <a href="{{ route('delivery.payment') }}" data-navlink
                        class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        Proceed to Checkout
                    </a>

                </div>
            </div>
        </div>
    </div>
@endif
