<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Delivery Details Form -->
    <div class="lg:col-span-2">
        <div class="bg-white rounded-lg shadow-lg p-6">
            <h2 class="text-xl font-semibold mb-6">Delivery Details</h2>

            <form class="space-y-6" action="{{ route('order.summary') }}" method="GET">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="first-name" class="block text-sm font-medium text-neutral-700 mb-1">First Name</label>
                        <input type="text" id="first-name" name="first-name"
                            class="w-full px-4 py-2 border border-neutral-300 rounded-lg focus:ring-primary-500 focus:border-primary-500"
                            value="" required>
                        <div class="text-red-500 text-sm mt-1 hidden"></div>
                    </div>

                    <div>
                        <label for="last-name" class="block text-sm font-medium text-neutral-700 mb-1">Last Name</label>
                        <input type="text" id="last-name" name="last-name"
                            class="w-full px-4 py-2 border border-neutral-300 rounded-lg focus:ring-primary-500 focus:border-primary-500"
                            value="" required>
                        <div class="text-red-500 text-sm mt-1 hidden"></div>
                    </div>
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-neutral-700 mb-1">Email Address</label>
                    <input type="email" id="email" name="email"
                        class="w-full px-4 py-2 border border-neutral-300 rounded-lg focus:ring-primary-500 focus:border-primary-500"
                        value="" required>
                    <div class="text-red-500 text-sm mt-1 hidden"></div>
                </div>

                <div>
                    <label for="phone" class="block text-sm font-medium text-neutral-700 mb-1">Phone Number</label>
                    <input type="tel" id="phone" name="phone"
                        class="w-full px-4 py-2 border border-neutral-300 rounded-lg focus:ring-primary-500 focus:border-primary-500"
                        value="" required>
                    <div class="text-red-500 text-sm mt-1 hidden"></div>
                </div>

                <div>
                    <label for="street" class="block text-sm font-medium text-neutral-700 mb-1">Street Address</label>
                    <input type="text" id="street" name="street"
                        class="w-full px-4 py-2 border border-neutral-300 rounded-lg focus:ring-primary-500 focus:border-primary-500"
                        value="" required>
                    <div class="text-red-500 text-sm mt-1 hidden"></div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label for="city" class="block text-sm font-medium text-neutral-700 mb-1">City</label>
                        <input type="text" id="city" name="city"
                            class="w-full px-4 py-2 border border-neutral-300 rounded-lg focus:ring-primary-500 focus:border-primary-500"
                            value="" required>
                        <div class="text-red-500 text-sm mt-1 hidden"></div>
                    </div>

                    <div>
                        <label for="zip" class="block text-sm font-medium text-neutral-700 mb-1">ZIP Code</label>
                        <input type="text" id="zip" name="zip"
                            class="w-full px-4 py-2 border border-neutral-300 rounded-lg focus:ring-primary-500 focus:border-primary-500"
                            value="" required>
                        <div id="zip-error" class="text-red-500 text-sm mt-1 hidden"></div>
                    </div>

                </div>


                <div class="flex justify-between pt-6 border-t border-neutral-200">
                    <a href="" data-navlink class="text-primary-500 hover:text-primary-700">
                        Back to Delivery & Payment
                    </a>

                    <button type="submit"
                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-blue-800">
                        Continue to Summary
                    </button>
                </div>
                @if ($errors->any())
                    <ul class="px-4 py-2 bg-red-100">
                        @foreach ($errors->all() as $error)
                            <li class="my-2 text-red-500">{{ $error }}</li>
                        @endforeach
                    </ul>
                @endif
            </form>
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

                <a href="{{ route('delivery.payment') }}" data-navlink
                    class="block w-full text-center text-primary-500 hover:text-primary-700">
                    Return to delivery payment
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
