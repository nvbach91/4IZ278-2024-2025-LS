<flux:header container class="bg-zinc-50 dark:bg-zinc-900 border-b border-zinc-200 dark:border-zinc-700">
    <flux:sidebar.toggle class="lg:hidden" icon="bars-2" />
    <flux:brand href="{{ route('index') }}"
        logo="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRLf8hZ5Hom0OLaDeIOuzkdHOMH3pKIWSEYOg&s"
        name="Cyklo obchod" class="max-lg:hidden dark:hidden" />
    <flux:brand href="{{ route('index') }}"
        logo="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRLf8hZ5Hom0OLaDeIOuzkdHOMH3pKIWSEYOg&s"
        name="Cyklo obchod" class="max-lg:hidden! hidden dark:flex" />
    <flux:navbar class="-mb-px max-lg:hidden">
        @foreach ($categories as $index => $category)
            @if ($index < 5)
                @if (request('category') == $category->id)
                    <flux:navlist.item href="{{ route('products.index', ['category' => $category->id]) }}" current>
                        {{ $category->name }}
                    </flux:navlist.item>
                @else
                    <flux:navlist.item href="{{ route('products.index', ['category' => $category->id]) }}">
                        {{ $category->name }}
                    </flux:navlist.item>
                @endif
            @endif
        @endforeach

        @if (count($categories) > 5)
            <flux:dropdown class="max-lg:hidden">
                <flux:navbar.item icon:trailing="chevron-down">Další</flux:navbar.item>
                <flux:navmenu>
                    @foreach ($categories as $index => $category)
                        @if ($index >= 5)
                            <flux:navmenu.item href="{{ route('products.index', ['category' => $category->id]) }}">
                                {{ $category->name }}
                            </flux:navmenu.item>
                        @endif
                    @endforeach
                </flux:navmenu>
            </flux:dropdown>
        @endif
    </flux:navbar>
    <flux:spacer />
    <flux:navbar class="-mb-px max-lg:hidden">
        <flux:navbar.item href="{{ route('cart.index') }}" icon="shopping-cart"></flux:navbar.item>
        <form class="max-w-md mx-auto" action="{{ route('products.index') }}" method="GET">
            <label for="default-search"
                class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Search</label>
            <div class="relative">
                <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                    </svg>
                </div>
                <input type="search" name="search" id="default-search"
                    class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    placeholder="Search product" />
                <button type="submit"
                    class="text-white absolute end-2.5 bottom-2.5 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Search</button>
            </div>
        </form>
        @guest
            <!-- pouze pro neprihlasene uzivatele -->
            <a href="{{ route('show.login') }}">login</a>
            <a href="{{ route('show.register') }}">register</a>
        @endguest
    </flux:navbar>
    @auth
        <flux:dropdown position="top" align="start">
            <flux:profile avatar="https://fluxui.dev/img/demo/user.png" />
            <flux:menu>
                <flux:menu.radio.group>
                    <flux:menu.radio><a href="{{ route('profile.index', Auth::user()->id) }}">{{ Auth::user()->name }}</a>
                    </flux:menu.radio>
                    @if (auth()->user()->privilege)
                        <flux:menu.radio><a href="{{ route('admin.categories') }}">Admin Categories</a></flux:menu.radio>
                        <flux:menu.radio><a href="{{ route('admin.users') }}">Admin Users</a></flux:menu.radio>
                        <flux:menu.radio><a href="{{ route('admin.orders') }}">Admin Orders</a></flux:menu.radio>
                    @endif
                </flux:menu.radio.group>
                <flux:menu.separator />
                <flux:menu.item icon="arrow-right-start-on-rectangle">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn">Logout</button>
                    </form>
                </flux:menu.item>
            </flux:menu>
        </flux:dropdown>
    @endauth
</flux:header>
