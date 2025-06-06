@extends('components.layouts.profileL')


<livewire:navbar :categories="$categories" />

<flux:main container>
    <!-- profile panel LiveWire component -->
    <livewire:profile-panel />
</flux:main>
