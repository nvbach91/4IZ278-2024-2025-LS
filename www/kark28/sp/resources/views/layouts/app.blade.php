@include('partials.header')
<script>
    window.SERVER_NOW = @json(\Carbon\Carbon::now()->toIso8601String());
    const BASE_URL = "{{ url('') }}";
    const CONFIRM_RESERVATION_URL = "{{ route('reservation.confirm') }}";
</script>
@include('partials.nav')

@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Zavřít"></button>
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Zavřít"></button>
    </div>
@endif

<div class="container mt-4">
    @yield('content')
</div>

@include('layouts.overlay')
@include('partials.footer')


@stack('scripts')
