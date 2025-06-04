@php($active = $active ?? '')

<div class="list-group list-group-flush p-3 bg-white rounded shadow-sm">
    <a href="{{ route('coach.dashboard') }}"
       class="list-group-item list-group-item-action {{ $active === 'dashboard' ? 'active' : '' }}">
        My courses
    </a>
    <a href="{{ route('coach.profile') }}"
       class="list-group-item list-group-item-action {{ $active === 'profile' ? 'active' : '' }}">
        Profile Settings
    </a>
</div>
