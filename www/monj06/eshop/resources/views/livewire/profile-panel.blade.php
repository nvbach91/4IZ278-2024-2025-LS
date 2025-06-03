<div class="grid grid-cols-1 md:grid-cols-3 gap-8">
    <div class="md:col-span-1">
        <div class="bg-white rounded-lg shadow-lg p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-semibold">Profile Information</h2>
            </div>

            <div class="space-y-4">
                <div class="flex items-center justify-between mb-4">
                    <div class="shrink-0">
                        <img class="w-8 h-8 rounded-full"
                            src="https://cdn3.iconfinder.com/data/icons/communication-social-media-1/24/account_profile_user_contact_person_avatar_placeholder-512.png"
                            alt="profile picture">
                    </div>
                    <h5 class="text-xl font-bold leading-none text-gray-900 dark:text-white">{{ Auth::user()->name }}
                    </h5>
                </div>

                <div class="flow-root">
                    <ul role="list" class="divide-y divide-gray-200 dark:divide-gray-700">
                        <li class="py-3 sm:py-4">
                            <div class="flex items-center justify-center">
                                <flux:button wire:click="setTab('profile')" class="w-full">Profil</flux:button>
                            </div>
                        </li>
                        <li class="py-3 sm:py-4">
                            <div class="flex items-center justify-center">
                                <flux:button wire:click="setTab('orders')" class="w-full">Objednávky</flux:button>
                            </div>
                        </li>
                        <li class="py-3 sm:py-4">
                            <div class="flex items-center justify-center">
                                <flux:button wire:click="setTab('addresses')" class="w-full">Adresy</flux:button>
                            </div>
                        </li>
                        <li class="py-3 sm:py-4">
                            <div class="flex items-center justify-center">
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <flux:button type="submit" variant="danger" class="w-full">Odhlásit</flux:button>
                                </form>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>


    <div class="col-span-2">
        <div class="bg-white rounded-lg shadow-lg p-6">
            @if ($tab === 'profile')
                <h2 class="text-xl font-semibold mb-6">Info</h2>
                <form class="max-w-sm mx-auto" action="{{ route('update.user', Auth::user()->id) }}" method="GET">
                    <div class="mb-5">
                        <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                            Name</label>
                        <input type="text" name="name"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            value="{{ Auth::user()->name }}" required />
                    </div>
                    <div class="mb-5">
                        <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                            Email</label>
                        <input type="email" name="email"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            value="{{ Auth::user()->email }}" required />
                    </div>
                    <div class="mb-5">
                        <label for="phone" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                            phone</label>
                        <input type="text" name="phone"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            value="{{ Auth::user()->phone }}" required />
                    </div>
                    <div class="mb-5">
                        <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                            password</label>
                        <input type="password" name="password"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="Type your new password" required />
                    </div>
                    <button type="submit"
                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Change</button>
                    <div>
                        @if ($errors->any())
                            <ul class="px-4 py-2 bg-red-100">
                                @foreach ($errors->all() as $error)
                                    <li class="my-2 text-red-500">{{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </form>
            @elseif ($tab === 'orders')
                <h2 class="text-xl font-semibold mb-6">Objednávky</h2>
                @foreach (Auth::user()->orders as $order)
                    <h2 id="accordion-collapse-heading-{{ $order->id }}">
                        <button type="button" wire:click="download({{ $order->id }})"
                            class="flex items-center justify-between w-full p-5 font-medium rtl:text-right text-gray-500 border border-b-0 border-gray-200 rounded-t-xl focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-800 dark:border-gray-700 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 gap-3"
                            data-accordion-target="#accordion-collapse-body-{{ $order->id }}" aria-expanded="true"
                            aria-controls="accordion-collapse-body-{{ $order->id }}">
                            <span>{{ $order->id }}</span>
                            <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="M9 5 5 1 1 5" />
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
                                                                        src="{{ $products[$item->product_id]['img'] }}"
                                                                        alt="product image">
                                                                </div>
                                                                <div class="ml-4">
                                                                    <a href="" data-navlink
                                                                        class="text-sm font-medium text-neutral-900 hover:text-primary-500">
                                                                        product price
                                                                    </a>
                                                                    <div class="text-sm text-neutral-500">
                                                                        product category
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
                                                            <div class="font-medium">
                                                                {{ $products[$item->product_id]['price'] }}
                                                            </div>
                                                        </td>
                                                        <td
                                                            class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium item-total">
                                                            {{ (int) $products[$item->product_id]['price'] * $item->quantity }}
                                                        </td>
                                                        <td
                                                            class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                            <a href="{{ route('delete.itemOrder', $item->product_id) }}"
                                                                class="remove-item text-red-500 hover:text-red-700">
                                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                                    class="h-5 w-5" viewBox="0 0 20 20"
                                                                    fill="currentColor">
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

                            <div class="lg:w-1/3">
                                <div class="bg-white rounded-lg shadow-lg p-6">
                                    <p>cena: {{ $order->price }}</p>
                                    <p>ulice: {{ $order->street }}</p>
                                    <p>PSČ: {{ $order->postal_code }}</p>
                                    <p>město: {{ $order->city }}</p>
                                    <p>doručení: {{ $order->delivery }}</p>
                                    <p>platba: {{ $order->payment }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @elseif ($tab === 'addresses')
                <h2 class="text-xl font-semibold mb-6">Adresa</h2>
                <form class="max-w-sm mx-auto" action="{{ route('update.user', Auth::user()->id) }}" method="GET">
                    <div class="mb-5">
                        <label for="street" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                            street</label>
                        <input type="text" name="street"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            value="{{ Auth::user()->street }}" required />
                    </div>
                    <div class="mb-5">
                        <label for="city" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                            city</label>
                        <input type="text" name="city"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            value="{{ Auth::user()->city }}" required />
                    </div>
                    <div class="mb-5">
                        <label for="postalCode" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                            postal code</label>
                        <input type="text" name="postalCode"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            value="{{ Auth::user()->postal_code }}" required />
                    </div>

                    <button type="submit"
                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Change</button>
                    <div>
                        @if ($errors->any())
                            <ul class="px-4 py-2 bg-red-100">
                                @foreach ($errors->all() as $error)
                                    <li class="my-2 text-red-500">{{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </form>
            @endif

        </div>
    </div>

</div>
