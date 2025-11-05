@props(['title' => null])

@php
    $user = auth()->user();
    // ✅ Same logic as middleware
    $isAdmin = $user && $user->hasAnyRole(['admin', 'editor', 'writer']);
    $isRegularUser = $user && $user->hasRole('user') && !$user->hasAnyRole(['admin', 'editor', 'writer']);
@endphp

@if($isAdmin)
    {{-- Admin/Editor/Writer: Show with sidebar --}}
    <x-layouts.app.sidebar :title="$title">
        <flux:main>
            {{ $slot }}
        </flux:main>
    </x-layouts.app.sidebar>
@elseif($isRegularUser)
    {{-- Regular User: Show without sidebar (use blog header) --}}
    <x-blog-header :title="$title">
        {{ $slot }}
    </x-blog-header>
@else
    {{-- Fallback for guests or users without roles --}}
    <x-blog-header :title="$title">
        {{ $slot }}

        <x-footer />
    </x-blog-header>
@endif