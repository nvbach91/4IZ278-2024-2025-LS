@once
    <link rel="stylesheet" href="{{ asset('css/overlay.css') }}">
@endonce

<div class="overlay-background" id="overlay">
    <div class="overlay-content">
        @yield('overlay')
    </div>
</div>

<script src="{{ asset('js/overlay.js') }}"></script>
