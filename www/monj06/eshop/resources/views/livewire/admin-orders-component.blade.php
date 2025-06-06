<div id="accordion-collapse" data-accordion="collapse">
    @foreach ($orders as $order)
        <h2 id="accordion-collapse-heading-{{ $order['id'] }}">
            <button type="button" wire:click="download({{ $order->id }})"
                class="flex items-center justify-between w-full p-5 font-medium rtl:text-right text-gray-500 border border-b-0 border-gray-200 rounded-t-xl focus:ring-4 focus:ring-gray-200 focus:ring-gray-800 gap-3"
                data-accordion-target="#accordion-collapse-body-{{ $order['id'] }}" aria-expanded="true"
                aria-controls="accordion-collapse-body-{{ $order['id'] }}">
                <div class="flex flex-col items-start text-left">
                    <span class="font-semibold">{{ $order->id }}</span>
                    <span class="text-sm text-gray-600">Status: {{ ucfirst($order->status) }}</span>
                    <span class="text-sm text-gray-600">Email: {{ $order->user->email ?? 'unknown' }}</span>
                    <span class="text-sm text-gray-600">Created: {{ $order->created_at->format('d.m.Y H:i') }}</span>
                </div>
                <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true"
                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 5 5 1 1 5" />
                </svg>
            </button>
        </h2>
        <div @if ($activeOrderId === $order->id) class="block" @else class="hidden" @endif
            aria-labelledby="accordion-collapse-heading-1">

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
                                @if (!is_null($items))
                                    @foreach ($items as $item)
                                        <tr class="cart-item" data-product-id="{{ $item->product_id }}">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <div
                                                        class="h-16 w-16 flex-shrink-0 rounded overflow-hidden bg-neutral-100">
                                                        <img class="h-full w-full object-cover"
                                                            src="{{ $products[$item->product_id]['image'] }}"
                                                            alt="product image">
                                                    </div>
                                                    <div class="ml-4">
                                                        <a href="" data-navlink
                                                            class="text-sm font-medium text-neutral-900 hover:text-primary-500">
                                                            {{ $products[$item->product_id]['name'] }}
                                                        </a>
                                                        <div class="text-sm text-neutral-500">
                                                            {{ $products[$item->product_id]['category'] }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center justify-center">
                                                    <input type="number" min="1" max="1"
                                                        value="{{ $item->quantity }}"
                                                        class="item-quantity w-12 text-center border-y border-neutral-300 py-1 focus:outline-none focus:ring-1 focus:ring-primary-500" />
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
                                                <div class="font-medium">{{ $products[$item->product_id]['price'] }}
                                                </div>
                                            </td>
                                            <td
                                                class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium item-total">
                                                {{ (int) $products[$item->product_id]['price'] * $item->quantity }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                <a href="{{ route('delete.itemOrder', $item->product_id) }}"
                                                    class="remove-item text-red-500 hover:text-red-700">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                                                        viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd"
                                                            d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                                            clip-rule="evenodd" />
                                                    </svg>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="lg:w-1/3">
                    <div class="bg-white rounded-lg shadow-lg p-6">


                        <form class="max-w-sm mx-auto" action="{{ route('update.order', $order->id) }}" method="GET">
                            <div class="mb-5">
                                <label for="price" class="block mb-2 text-sm font-medium text-gray-900">
                                    price</label>
                                <input type="text" name="price"
                                    class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 border-gray-600 placeholder-gray-400 focus:ring-blue-500 focus:border-blue-500"
                                    value="{{ $order->price }}" required />
                            </div>
                            <div class="mb-5">
                                <label for="userId" class="block mb-2 text-sm font-medium text-gray-900">
                                    userId</label>
                                <input type="text" name="userId"
                                    class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 border-gray-600 placeholder-gray-400 focus:ring-blue-500 focus:border-blue-500"
                                    value="{{ $order->user_id }}" required />
                            </div>
                            <div class="mb-5">
                                <label for="status" class="block mb-2 text-sm font-medium text-gray-900">
                                    status</label>
                                <input type="text" name="status"
                                    class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 border-gray-600 placeholder-gray-400 focus:ring-blue-500 focus:border-blue-500"
                                    value="{{ $order->status }}" required />
                            </div>
                            <div class="mb-5">
                                <label for="street" class="block mb-2 text-sm font-medium text-gray-900">
                                    street</label>
                                <input type="text" name="street"
                                    class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 border-gray-600 placeholder-gray-400 focus:ring-blue-500 focus:border-blue-500"
                                    value="{{ $order->street }}" required />
                            </div>
                            <div class="mb-5">
                                <label for="postalCode" class="block mb-2 text-sm font-medium text-gray-900">
                                    postal code</label>
                                <input type="text" name="postalCode"
                                    class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 border-gray-600 placeholder-gray-400 focus:ring-blue-500 focus:border-blue-500"
                                    value="{{ $order->postal_code }}" required />
                            </div>
                            <div class="mb-5">
                                <label for="city" class="block mb-2 text-sm font-medium text-gray-900">
                                    city</label>
                                <input type="text" name="city"
                                    class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 border-gray-600 placeholder-gray-400 focus:ring-blue-500 focus:border-blue-500"
                                    value="{{ $order->city }}" required />
                            </div>
                            <button type="submit"
                                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center bg-blue-600 hover:bg-blue-700 focus:ring-blue-800">Change</button>
                        </form>
                        <a href="{{ route('delete.order', $order->id) }}"
                            class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 bg-red-600 hover:bg-red-700 focus:ring-red-900">Delete</a>



                    </div>
                </div>
            </div>



        </div>
    @endforeach
</div>
