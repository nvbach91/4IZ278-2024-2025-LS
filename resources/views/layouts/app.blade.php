<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Moje Appka')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    {{-- Bootstrap CDN only, no build step needed --}}
</head>
<body>

    {{-- FLASH BANNERY --}}
    @if (session('success'))
        <div id="flash-banner" class="alert alert-success alert-dismissible fade show position-fixed top-0 start-50 translate-middle-x mt-3 shadow" role="alert">
            <span>{{ session('success') }}</span>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (session('error'))
        <div id="flash-banner" class="alert alert-danger alert-dismissible fade show position-fixed top-0 start-50 translate-middle-x mt-3 shadow" role="alert">
            <span>{{ session('error') }}</span>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- ZDE INCLUDUJEME NAVBAR Z partials/navbar.blade.php --}}
    @include('partials.navbar')

    {{-- HLAVNÍ OBLAST (z jiných layoutů dědí obsah) --}}
    <div class="pt-4 container"> {{-- lehký odsazení pod navbar --}}
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    {{-- Skript pro flash banner a inicializaci carouselu --}}
    <script>
        (() => {
            const banner = document.getElementById('flash-banner');
            if (banner) {
                const alert = bootstrap.Alert.getOrCreateInstance(banner);
                setTimeout(() => alert.close(), 3000);
            }

            document.querySelectorAll('.carousel').forEach(el => {
                new bootstrap.Carousel(el);
            });
        })();
    </script>
</body>
</html>
