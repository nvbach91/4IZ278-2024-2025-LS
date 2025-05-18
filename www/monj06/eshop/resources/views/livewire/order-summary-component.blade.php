<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Order Details -->
    <div class="lg:col-span-2">
        <div class="bg-white rounded-lg shadow-lg p-6 mb-8">
            <h2 class="text-xl font-semibold mb-6">Order Summary</h2>

            <!-- Delivery Details -->
            <div class="mb-8">
                <h3 class="font-medium text-lg mb-4">Delivery Details</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <div class="text-sm text-neutral-500 mb-1">Name</div>
                        <div>name</div>
                    </div>
                    <div>
                        <div class="text-sm text-neutral-500 mb-1">Email</div>
                        <div>email</div>
                    </div>
                    <div>
                        <div class="text-sm text-neutral-500 mb-1">Phone</div>
                        <div>phone</div>
                    </div>
                    <div>
                        <div class="text-sm text-neutral-500 mb-1">Address</div>
                        <div>
                            street<br>
                            city, Postal Code<br>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Shipping Method -->
            <div class="mb-8">
                <h3 class="font-medium text-lg mb-4">Shipping Method</h3>
                <div class="flex items-center">

                    <div>

                    </div>
                    <div class="ml-auto font-medium">
                        Price
                    </div>
                </div>
            </div>

            <!-- Payment Method -->
            <div>
                <h3 class="font-medium text-lg mb-4">Payment Method</h3>
                <div class="flex items-center">

                    <div>

                    </div>
                </div>
            </div>
        </div>

        <!-- Order Items -->
        <div class="bg-white rounded-lg shadow-lg p-6">
            <h2 class="text-xl font-semibold mb-6">Order Items</h2>

            <div class="space-y-6">
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
                                    {{ $item['price'] * $item['quantity'] }}
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Order Total -->
    <div class="lg:col-span-1">
        <div class="bg-white rounded-lg shadow-lg p-6 sticky top-24">
            <h2 class="text-xl font-semibold mb-6">Order Total</h2>

            <div class="space-y-4 mb-6">
                <div class="flex justify-between text-neutral-700">
                    <span>Subtotal</span>
                    <span>Total price</span>
                </div>
                <div class="flex justify-between text-neutral-700">
                    <span>Shipping</span>
                    <span>Shipping price</span>
                </div>
                <div class="flex justify-between font-bold text-neutral-900 pt-4 border-t border-neutral-200">
                    <span>Total</span>
                    <span>Total With Shipping</span>
                </div>
            </div>


            <div class="space-y-4">
                <button id="place-order-btn"
                    class="block w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    Place Order
                </button>

                <a href="/delivery-details.html" data-navlink
                    class="block w-full text-center text-primary-500 hover:text-primary-700">
                    Back to Delivery Details
                </a>
            </div>
        </div>
    </div>
</div>
