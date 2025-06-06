@extends('layouts.app')

@section('content')
<div class="d-flex min-vh-100">

    {{-- SIDEBAR --}}
    <aside class="bg-light border-end" style="width: 14rem;">
        {{-- $sidebarActive předá každá stránka --}}
        @include('partials.sidebar', ['active' => $sidebarActive ?? ''])
    </aside>

    {{-- HLAVNÍ OBLAST --}}
    <section class="flex-grow-1 p-4">
        @yield('student-content')
    </section>

</div>
@endsection
