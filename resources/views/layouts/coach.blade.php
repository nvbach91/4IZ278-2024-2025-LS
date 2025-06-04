{{-- resources/views/layouts/coach.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="d-flex min-vh-100">

    {{-- LEVÝ SLUPEC – sidebar‐coach --}}
    <aside class="bg-light border-end" style="width: 14rem;">
        @include('partials.sidebar-coach', ['active' => $sidebarActive ?? 'dashboard'])
    </aside>

    {{-- Hlavní oblast pro coach‐obsah --}}
    <section class="flex-grow-1 p-4">
        @yield('coach-content')
    </section>

</div>
@endsection
