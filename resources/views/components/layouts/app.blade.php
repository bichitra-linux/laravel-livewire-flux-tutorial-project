@props(['title' => null])

@php
    $user = auth()->user();
    $isAdmin = $user && $user->hasAnyRole(['admin', 'editor', 'writer']);
    $isRegularUser = $user && $user->hasRole('user') && !$user->hasAnyRole(['admin', 'editor', 'writer']);
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>{{ $title ?? config('app.name') }}</title>
    
    {{-- ✅ ADD Google Analytics --}}
    <x-google-analytics />
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body>
    @if($isAdmin)
        <x-layouts.app.sidebar :title="$title">
            <flux:main>
                {{ $slot }}
            </flux:main>
        </x-layouts.app.sidebar>
    @elseif($isRegularUser)
        <x-blog-header :title="$title">
            {{ $slot }}
        </x-blog-header>
    @else
        <x-blog-header :title="$title">
            {{ $slot }}
            <x-footer />
        </x-blog-header>
    @endif
    
    @livewireScripts
</body>
</html>