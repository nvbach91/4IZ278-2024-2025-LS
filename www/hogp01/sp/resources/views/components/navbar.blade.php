<header class="navbar">
    <div class="left-section">
        <div class="logo"><a href="{{ route('homepage') }}"><strong>{{ config('app.name') }}</strong></a></div>
        <nav class="nav-links">
        <a href="{{ route('products', ['gender' => 'Muži']) }}">Muži</a>
        <a href="{{ route('products', ['gender' => 'Ženy']) }}">Ženy</a>
        </nav>
    </div>
    <div class="nav-actions">
        @guest
            <a href="{{ route('login') }}">Login</a>
        @endguest

        @auth
            @if (Auth::user()->role === 'admin')
                <a href="{{ route('admin.orders.index') }}">Objednávky</a>
                <a href="{{ route('admin.products.index') }}">Produkty</a>

            @else
                <a href="{{ route('cart.index') }}"><i class="bi bi-bag"></i></a>
                <a href="#"><i class="bi bi-person-circle"></i></a>
            @endif
                <a href="{{ route('logout') }}"><i class="bi bi-box-arrow-right"></i></a>

        @endauth

    </div>
</header>
