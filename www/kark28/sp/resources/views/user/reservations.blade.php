@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Your Reservations</h2>

    <ul class="nav nav-tabs" id="reservationTabs">
        <li class="nav-item">
            <a class="nav-link {{ ($initialTab ?? 'active') === 'active' ? 'active' : '' }}"
               href="#" data-url="{{ route('reservations.active') }}">Active</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ ($initialTab ?? 'active') === 'past' ? 'active' : '' }}"
               href="#" data-url="{{ route('reservations.past') }}">Past</a>
        </li>
    </ul>

    <div class="mt-4" id="reservation-content">
        {!! $initialContent ?? '<div class="text-muted">Loading...</div>' !!}
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const tabs = document.querySelectorAll('#reservationTabs .nav-link');
        const content = document.getElementById('reservation-content');

        function loadTab(url, clickedTab) {
            tabs.forEach(tab => tab.classList.remove('active'));
            clickedTab.classList.add('active');
            content.innerHTML = '<div class="text-muted">Loading...</div>';

            fetch(url)
                .then(res => res.text())
                .then(html => {
                    content.innerHTML = html;
                });
        }

        tabs.forEach(tab => {
            tab.addEventListener('click', function (e) {
                e.preventDefault();
                loadTab(this.dataset.url, this);
            });
        });

        @if (!isset($initialContent))
            loadTab(tabs[0].dataset.url, tabs[0]);
        @endif
    });
</script>
@endsection
