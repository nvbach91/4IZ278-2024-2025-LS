<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Delivery & Payment Options -->
    <div class="lg:col-span-2">
        <div class="bg-white rounded-lg shadow-lg p-6 mb-8">
            <h2 class="text-xl font-semibold mb-6">Shipping Method</h2>

            <div class="space-y-4">
                <label class="block">
                    <div class="flex items-center">
                        <input type="radio" name="shipping" value="standard" checked
                            class="h-4 w-4 text-primary-500 focus:ring-primary-500 border-neutral-300">
                        <div class="ml-3 flex justify-between flex-grow">
                            <div>
                                <span class="font-medium">Standard Shipping</span>
                                <p class="text-sm text-neutral-500">Delivery in 3-5 business days</p>
                            </div>
                            <span class="font-medium">FREE</span>
                        </div>
                    </div>
                </label>

                <label class="block">
                    <div class="flex items-center">
                        <input type="radio" name="shipping" value="express"
                            class="h-4 w-4 text-primary-500 focus:ring-primary-500 border-neutral-300">
                        <div class="ml-3 flex justify-between flex-grow">
                            <div>
                                <span class="font-medium">Express Shipping</span>
                                <p class="text-sm text-neutral-500">Delivery in 1-2 business days</p>
                            </div>
                            <span class="font-medium">FREE</span>
                        </div>
                    </div>
                </label>

                <label class="block">
                    <div class="flex items-center">
                        <input type="radio" name="shipping" value="pickup"
                            class="h-4 w-4 text-primary-500 focus:ring-primary-500 border-neutral-300">
                        <div class="ml-3 flex justify-between flex-grow">
                            <div>
                                <span class="font-medium">Store Pickup</span>
                                <p class="text-sm text-neutral-500">Usually ready in 24 hours</p>
                            </div>
                            <span class="font-medium">FREE</span>
                        </div>
                    </div>
                </label>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-lg p-6">
            <h2 class="text-xl font-semibold mb-6">Payment Method</h2>

            <div class="space-y-4">
                <label class="block">
                    <div class="flex items-center">
                        <input type="radio" name="payment" value="card" checked
                            class="h-4 w-4 text-primary-500 focus:ring-primary-500 border-neutral-300">
                        <div class="ml-3">
                            <span class="font-medium">Credit/Debit Card</span>
                        </div>
                    </div>
                </label>

                <label class="block">
                    <div class="flex items-center">
                        <input type="radio" name="payment" value="paypal"
                            class="h-4 w-4 text-primary-500 focus:ring-primary-500 border-neutral-300">
                        <div class="ml-3">
                            <span class="font-medium">PayPal</span>
                        </div>
                    </div>
                </label>

                <label class="block">
                    <div class="flex items-center">
                        <input type="radio" name="payment" value="bank"
                            class="h-4 w-4 text-primary-500 focus:ring-primary-500 border-neutral-300">
                        <div class="ml-3">
                            <span class="font-medium">Bank Transfer</span>
                        </div>
                    </div>
                </label>
            </div>
        </div>
    </div>

    <!-- Order Summary -->
    <div class="lg:col-span-1">
        <div class="bg-white rounded-lg shadow-lg p-6 sticky top-24">
            <h2 class="text-xl font-semibold mb-6">Order Summary</h2>

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

            <div class="space-y-4">
                <a href="{{ route('delivery.details') }}" data-navlink
                    class="block w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center bg-blue-600 hover:bg-blue-700 focus:ring-blue-800">
                    Continue to Delivery Details
                </a>

                <a href="{{ route('cart.index') }}" data-navlink
                    class="block w-full text-center text-primary-500 hover:text-primary-700">
                    Return to Cart
                </a>
            </div>

            <div class="mt-6 pt-6 border-t border-neutral-200">
                <h3 class="font-medium mb-2">Order Items: {{ count($cart) }}</h3>
                <div class="space-y-4">
                    @foreach ($cart as $id => $item)
                        <div class="flex items-center">
                            <div class="h-16 w-16 flex-shrink-0 rounded overflow-hidden bg-neutral-100">
                                <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}"
                                    class="h-full w-full object-cover">
                            </div>
                            <div class="ml-4 flex-grow">
                                <h4 class="text-sm font-medium">{{ $item['name'] }}</h4>
                                <div class="text-sm text-neutral-500">Quantity: {{ $item['quantity'] }}</div>
                            </div>
                            <div class="ml-4 text-sm font-medium">
                                {{ (int) $item['price'] * $item['quantity'] }}
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
