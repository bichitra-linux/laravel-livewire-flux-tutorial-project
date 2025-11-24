<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? config('app.name', 'The Brief') }}</title>

    <link rel="icon" href="/favicon.ico" sizes="any">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    @include('partials.head')
    @livewireStyles
</head>

<body class="antialiased bg-gray-50 dark:bg-gray-900">

    {{-- Header --}}
    <header
        class="bg-white dark:bg-gray-900 border-b border-gray-200 dark:border-gray-700 sticky top-0 z-50 backdrop-blur-xl shadow-sm">
        {{-- Top Bar --}}
        <div wire:navigate.stop
            class="sticky top-0 z-50 bg-white/80 dark:bg-gray-900/80 backdrop-blur-md border-b border-gray-200/50 dark:border-gray-800/50">
            <div class="max-w-7xl mx-auto px-2 sm:px-4 lg:px-6">
                <div class="grid grid-cols-3 items-center gap-2 h-12 sm:h-12">
                    {{-- Left: Date & Time - Compact on mobile --}}
                    <div class="flex items-center gap-2 justify-start">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:gap-3">
                            <div class="flex items-center gap-1 group">
                                <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 text-gray-400 dark:text-gray-500 group-hover:text-blue-500 dark:group-hover:text-blue-400 transition-colors"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                    </path>
                                </svg>
                                <time id="current-date"
                                    class="text-[10px] leading-tight sm:text-sm font-medium text-gray-700 dark:text-gray-300 transition-opacity duration-300"
                                    datetime="">
                                    {{-- Empty, will be filled by script below --}}
                                    <span id="date-display"></span>
                                </time>
                            </div>

                            <span class="hidden sm:inline text-gray-300 dark:text-gray-700 select-none"
                                aria-hidden="true">•</span>

                            <div class="flex items-center gap-1 group">
                                <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 text-gray-400 dark:text-gray-500 group-hover:text-blue-500 dark:group-hover:text-blue-400 transition-colors"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <time id="current-time"
                                    class="text-[10px] leading-tight sm:text-sm font-medium text-gray-700 dark:text-gray-300 tabular-nums"
                                    datetime="">
                                    {{-- Empty, will be filled by script below --}}
                                </time>
                            </div>
                        </div>
                    </div>

                    {{-- Center: Weather Widget - Always visible --}}
                    <div id="weather-widget" class="flex items-center justify-center">
                        {{-- Loading State --}}
                        <div id="weather-loading" class="flex items-center gap-1.5">
                            <div class="w-4 h-4 sm:w-6 sm:h-6 rounded-full bg-gray-100 dark:bg-gray-800 animate-pulse">
                            </div>
                            <div class="w-8 h-2 sm:w-12 sm:h-4 bg-gray-100 dark:bg-gray-800 rounded animate-pulse">
                            </div>
                        </div>

                        {{-- Weather Content --}}
                        <button id="weather-content"
                            class="hidden items-center gap-1.5 px-2 py-1 sm:px-3 sm:py-1.5 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 transition-all duration-200 group"
                            aria-label="Weather information" title="Click to refresh weather">
                            <span class="text-xl sm:text-2xl transition-transform group-hover:scale-110"
                                id="weather-icon" role="img" aria-label="Weather icon">☁️</span>
                            <div class="flex flex-col items-start min-w-0">
                                <span
                                    class="text-xs sm:text-sm font-semibold text-gray-900 dark:text-white tabular-nums leading-tight"
                                    id="weather-temp">--°C</span>
                                <span
                                    class="text-[9px] sm:text-xs text-gray-500 dark:text-gray-400 leading-tight truncate max-w-[60px] sm:max-w-none"
                                    id="weather-desc">Loading...</span>
                            </div>
                        </button>

                        {{-- Error State --}}
                        <div id="weather-error"
                            class="hidden items-center gap-1.5 text-xs text-gray-500 dark:text-gray-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z">
                                </path>
                            </svg>
                            <span class="text-[10px] sm:text-xs">Unavailable</span>
                        </div>
                    </div>

                    {{-- Right: Theme & Auth --}}
                    <div class="flex items-center gap-1.5 sm:gap-2 justify-end">
                        {{-- Theme Toggle --}}
                        <button id="theme-toggle" type="button" aria-label="Toggle dark mode" onclick="toggleTheme()"
                            class="relative p-1.5 sm:p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 group">

                            <!-- Moon icon (light mode default) -->
                            <svg id="theme-toggle-dark-icon"
                                class="w-6 h-6 text-gray-800 dark:text-gray-900 transition-all duration-300"
                                style="transform: scale(1); position: relative; z-index: 10;" fill="currentColor"
                                viewBox="0 0 20 20">
                                <path d="M17.293 13.293A8 8 0 116.707 2.707a7 7 0 1010.586 10.586z" />
                            </svg>

                            <!-- Sun icon (hidden initially) -->
                            <svg id="theme-toggle-light-icon"
                                class="w-5 h-5 text-yellow-500 transition-transform duration-300 absolute inset-0 m-auto"
                                style="transform: rotate(90deg) scale(0);" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z"
                                    clip-rule="evenodd"></path>
                            </svg>

                        </button>

                        @guest
                            <a href="{{ route('login') }}"
                                class="px-2 py-1.5 sm:px-4 sm:py-2 text-[10px] sm:text-sm font-medium text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-lg transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 whitespace-nowrap">
                                Sign In
                            </a>
                        @endguest
                    </div>
                </div>
            </div>
        </div>

        {{-- Main Header --}}
        <div class="max-w-7xl mx-auto px-3 sm:px-4 lg:px-4">
            <div class="flex items-center justify-between py-2">

                {{-- Logo Section --}}
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="group flex items-center gap-4" wire:navigate>
                        <div class="relative">
                            <div
                                class="absolute inset-0 bg-linear-to-r from-blue-600 to-purple-600 rounded-2xl blur opacity-40 group-hover:opacity-60 transition-opacity">
                            </div>
                            <div
                                class="relative w-10 h-10 rounded-2xl bg-linear-to-br from-blue-600 via-purple-600 to-pink-600 flex items-center justify-center shadow-lg group-hover:shadow-xl transition-shadow duration-300">
                                <span class="text-2xl font-black text-white">B</span>
                            </div>
                        </div>
                        <div class="hidden sm:block">
                            <h1
                                class="text-2xl font-black text-gray-900 dark:text-white tracking-tight group-hover:text-transparent group-hover:bg-linear-to-r group-hover:from-blue-600 group-hover:to-purple-600 group-hover:bg-clip-text transition-all duration-300">
                                {{ $title ?? 'The Brief' }}
                            </h1>
                            <p class="text-xs text-gray-500 dark:text-gray-400 font-medium tracking-wider uppercase">
                                News • Analysis • Insights
                            </p>
                        </div>
                    </a>
                </div>

                {{-- Desktop Navigation --}}
                <nav class="hidden lg:flex items-center gap-2">
                    <a href="{{ route('home') }}"
                        class="group relative px-4 py-2 rounded-xl text-sm font-semibold text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition-colors duration-200 {{ request()->routeIs('home') ? 'text-blue-600 dark:text-blue-400' : '' }}"
                        wire:navigate>
                        <span class="relative z-10 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                                </path>
                            </svg>
                            Home
                        </span>
                        @if(request()->routeIs('home'))
                            <span class="absolute inset-0 bg-blue-50 dark:bg-blue-900/20 rounded-xl"></span>
                        @endif
                    </a>
                    <a href="{{ route('public.posts.index') }}"
                        class="group relative px-4 py-2 rounded-xl text-sm font-semibold text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition-colors duration-200 {{ request()->routeIs('public.posts.*') ? 'text-blue-600 dark:text-blue-400' : '' }}"
                        wire:navigate>
                        <span class="relative z-10 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z">
                                </path>
                            </svg>
                            Articles
                        </span>
                        @if(request()->routeIs('public.posts.*'))
                            <span class="absolute inset-0 bg-blue-50 dark:bg-blue-900/20 rounded-xl"></span>
                        @endif
                    </a>
                    <a href="{{ route('about') }}"
                        class="group relative px-4 py-2 rounded-xl text-sm font-semibold text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition-colors duration-200 {{ request()->routeIs('about') ? 'text-blue-600 dark:text-blue-400' : '' }}"
                        wire:navigate>
                        <span class="relative z-10 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            About
                        </span>
                        @if(request()->routeIs('about'))
                            <span class="absolute inset-0 bg-blue-50 dark:bg-blue-900/20 rounded-xl"></span>
                        @endif
                    </a>
                    <a href="{{ route('contact') }}"
                        class="group relative px-4 py-2 rounded-xl text-sm font-semibold text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition-colors duration-200 {{ request()->routeIs('contact') ? 'text-blue-600 dark:text-blue-400' : '' }}"
                        wire:navigate>
                        <span class="relative z-10 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                </path>
                            </svg>
                            Contact
                        </span>
                        @if(request()->routeIs('contact'))
                            <span class="absolute inset-0 bg-blue-50 dark:bg-blue-900/20 rounded-xl"></span>
                        @endif
                    </a>
                </nav>

                {{-- Right Actions --}}
                <div class="flex items-center gap-2">
                    @auth
                        @php
                            $user = auth()->user();
                            $isAdmin = $user->hasAnyRole(['admin', 'editor', 'writer']);
                            $isRegularUser = $user->hasRole('user') && !$user->hasAnyRole(['admin', 'editor', 'writer']);
                        @endphp

                        {{-- User Menu (Desktop) --}}
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" @click.away="open = false"
                                class="flex items-center gap-2 px-3 sm:px-4 py-2 rounded-xl hover:bg-gray-100 dark:hover:bg-gray-800 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 group w-full sm:w-auto">
                                <div class="relative shrink-0">
                                    <div
                                        class="w-8 h-8 sm:w-9 sm:h-9 rounded-xl bg-linear-to-br from-purple-500 via-pink-500 to-red-500 flex items-center justify-center text-white text-sm font-bold shadow-md group-hover:shadow-lg transition-shadow">
                                        {{ $user->initials() }}
                                    </div>
                                    <div
                                        class="absolute -bottom-0.5 -right-0.5 w-3 h-3 sm:w-3.5 sm:h-3.5 bg-green-500 border-2 border-white dark:border-gray-900 rounded-full">
                                    </div>
                                </div>
                                <div class="flex-1 text-left min-w-0">
                                    <p class="text-sm font-semibold text-gray-900 dark:text-white leading-none truncate">
                                        {{ $user->name }}
                                    </p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5 truncate">
                                        {{ $user->getRoleNames()->first() ?? 'User' }}
                                    </p>
                                </div>
                                <svg class="w-4 h-4 text-gray-400 transition-transform duration-200 shrink-0"
                                    :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>

                            {{-- Dropdown --}}
                            <div x-show="open" x-transition:enter="transition ease-out duration-200"
                                x-transition:enter-start="opacity-0 scale-95 translate-y-2"
                                x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                                x-transition:leave="transition ease-in duration-150"
                                x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                                class="absolute right-0 mt-3 w-72 bg-white dark:bg-gray-800 rounded-2xl shadow-2xl border border-gray-200 dark:border-gray-700 overflow-hidden z-50"
                                style="display: none;">

                                {{-- User Info Card --}}
                                <div
                                    class="p-2 bg-linear-to-br from-blue-50 to-purple-50 dark:from-blue-900/20 dark:to-purple-900/20 border-b border-gray-200 dark:border-gray-700">
                                    <div class="flex items-center gap-2.5">
                                        <div class="relative">
                                            <div
                                                class="w-8 h-8 rounded-xl bg-linear-to-br from-purple-500 via-pink-500 to-red-500 flex items-center justify-center text-white font-bold text-lg shadow-lg">
                                                {{ $user->initials() }}
                                            </div>
                                            <div
                                                class="absolute -bottom-1 -right-1 w-4 h-4 bg-green-500 border-3 border-white dark:border-gray-800 rounded-full">
                                            </div>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-base font-bold text-gray-900 dark:text-white truncate">
                                                {{ $user->name }}
                                            </p>
                                            <p class="text-xs text-gray-600 dark:text-gray-400 truncate">{{ $user->email }}
                                            </p>
                                            <span
                                                class="inline-flex items-center gap-1 mt-1 px-2 py-0.5 bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 rounded-full text-xs font-medium">
                                                <svg class="w-2 h-2" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd"
                                                        d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                                        clip-rule="evenodd"></path>
                                                </svg>
                                                {{ $user->getRoleNames()->first() ?? 'User' }}
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                {{-- Menu Items --}}
                                <div class="py-2">
                                    @if($isAdmin)
                                        <a href="{{ route('dashboard') }}"
                                            class="flex items-center gap-2 px-2 py-2 text-sm font-medium text-gray-700 dark:text-gray-200 hover:bg-blue-50 dark:hover:bg-blue-900/20 hover:text-blue-600 dark:hover:text-blue-400 transition-colors"
                                            wire:navigate>
                                            <div
                                                class="w-4 h-4 rounded-lg bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center">
                                                <svg class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                                                    </path>
                                                </svg>
                                            </div>
                                            <span>Dashboard</span>
                                        </a>
                                        <a href="{{ route('admin.profile.edit') }}"
                                            class="flex items-center gap-2 px-2 py-2 text-sm font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors"
                                            wire:navigate>
                                            <div
                                                class="w-4 h-4 rounded-lg bg-gray-100 dark:bg-gray-700 flex items-center justify-center">
                                                <svg class="w-4 h-4 text-gray-600 dark:text-gray-400" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z">
                                                    </path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                </svg>
                                            </div>
                                            <span>Settings</span>
                                        </a>
                                    @elseif($isRegularUser)
                                        <a href="{{ route('user.profile.edit') }}"
                                            class="flex items-center gap-2 px-2 py-2 text-sm font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors"
                                            wire:navigate>
                                            <div
                                                class="w-4 h-4 rounded-lg bg-gray-100 dark:bg-gray-700 flex items-center justify-center">
                                                <svg class="w-4 h-4 text-gray-600 dark:text-gray-400" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z">
                                                    </path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                </svg>
                                            </div>
                                            <span>Settings</span>
                                        </a>
                                    @endif
                                </div>

                                {{-- Logout --}}
                                <div class="border-t border-gray-200 dark:border-gray-700 p-1">
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit"
                                            class="flex items-center gap-2 w-full px-2 py-2 text-sm font-medium text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition-colors">
                                            <div
                                                class="w-4 h-4 rounded-lg bg-red-100 dark:bg-red-900/30 flex items-center justify-center">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                                                    </path>
                                                </svg>
                                            </div>
                                            <span>Logout</span>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>

                    @else
                        {{-- Guest CTA --}}
                        <div class="hidden md:flex items-center gap-2">
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}"
                                    class="inline-flex items-center gap-2 px-2 py-2 bg-linear-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white font-semibold rounded-xl shadow-md hover:shadow-lg transition-all duration-200 transform hover:scale-105">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z">
                                        </path>
                                    </svg>
                                    Get Started
                                </a>
                            @endif
                        </div>
                    @endauth

                    {{-- Mobile Menu Toggle --}}
                    <button id="mobile-menu-toggle" type="button" aria-label="Toggle Menu"
                        class="lg:hidden p-2 rounded-xl hover:bg-gray-100 dark:hover:bg-gray-800 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <svg id="menu-open-icon" class="w-4 h-4 text-gray-700 dark:text-gray-200" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                        <svg id="menu-close-icon" class="w-4 h-4 text-gray-700 dark:text-gray-200 hidden" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        {{-- Mobile Menu --}}
        <div id="mobile-menu"
            class="lg:hidden hidden border-t border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900">
            <nav class="max-w-7xl mx-auto px-2 sm:px-2 lg:px-4 py-4 space-y-1">


                {{-- Navigation Links --}}
                <a href="{{ route('home') }}"
                    class="flex items-center gap-2 px-2 py-2 text-base font-semibold rounded-xl transition-all duration-200 {{ request()->routeIs('home') ? 'bg-blue-50 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400' : 'text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-800' }}"
                    wire:navigate>
                    <div
                        class="w-4 h-4 rounded-lg {{ request()->routeIs('home') ? 'bg-blue-100 dark:bg-blue-900/30' : 'bg-gray-100 dark:bg-gray-800' }} flex items-center justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                            </path>
                        </svg>
                    </div>
                    <span>Home</span>
                </a>
                <a href="{{ route('public.posts.index') }}"
                    class="flex items-center gap-2 px-2 py-2 text-base font-semibold rounded-xl transition-all duration-200 {{ request()->routeIs('public.posts.*') ? 'bg-blue-50 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400' : 'text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-800' }}"
                    wire:navigate>
                    <div
                        class="w-4 h-4 rounded-lg {{ request()->routeIs('public.posts.*') ? 'bg-blue-100 dark:bg-blue-900/30' : 'bg-gray-100 dark:bg-gray-800' }} flex items-center justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z">
                            </path>
                        </svg>
                    </div>
                    <span>Articles</span>
                </a>
                <a href="{{ route('about') }}"
                    class="flex items-center gap-2 px-2 py-2 text-base font-semibold rounded-xl transition-all duration-200 {{ request()->routeIs('about') ? 'bg-blue-50 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400' : 'text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-800' }}"
                    wire:navigate>
                    <div
                        class="w-4 h-4 rounded-lg {{ request()->routeIs('about') ? 'bg-blue-100 dark:bg-blue-900/30' : 'bg-gray-100 dark:bg-gray-800' }} flex items-center justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <span>About</span>
                </a>
                <a href="{{ route('contact') }}"
                    class="flex items-center gap-2 px-2 py-2 text-base font-semibold rounded-xl transition-all duration-200 {{ request()->routeIs('contact') ? 'bg-blue-50 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400' : 'text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-800' }}"
                    wire:navigate>
                    <div
                        class="w-4 h-4 rounded-lg {{ request()->routeIs('contact') ? 'bg-blue-100 dark:bg-blue-900/30' : 'bg-gray-100 dark:bg-gray-800' }} flex items-center justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                            </path>
                        </svg>
                    </div>
                    <span>Contact</span>
                </a>


            </nav>
        </div>
    </header>

    {{-- Main Content --}}
    {{ $slot }}

    {{-- Scripts --}}
    <script>
        // STEP 1: Inline script in <head> or right after time elements
        // This sets initial time INSTANTLY before any framework loads
        (function () {
            'use strict';

            function setInitialTime() {
                const now = new Date();
                const dateEl = document.getElementById('date-display');
                const timeEl = document.getElementById('current-time');
                const dateParent = document.getElementById('current-date');

                if (dateEl) {
                    const isMobile = window.innerWidth < 640;
                    const dateText = isMobile
                        ? now.toLocaleDateString('en-US', { month: 'numeric', day: 'numeric' })
                        : now.toLocaleDateString('en-US', { weekday: 'short', month: 'short', day: 'numeric' });
                    dateEl.textContent = dateText;
                }

                if (dateParent) {
                    dateParent.setAttribute('datetime', now.toISOString().split('T')[0]);
                }

                if (timeEl) {
                    const time = now.toLocaleTimeString('en-US', {
                        hour: '2-digit',
                        minute: '2-digit',
                        hour12: true
                    });
                    const isoTime = now.toTimeString().split(' ')[0];
                    timeEl.setAttribute('datetime', isoTime);
                    timeEl.textContent = time;
                }
            }

            // Run immediately - even before DOM is fully parsed
            setInitialTime();

            // Run again when DOM is ready (in case elements weren't available yet)
            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', setInitialTime);
            }
        })();

        // STEP 2: Main module for continuous updates
        window.HeaderModule = (function () {
            'use strict';

            const CACHE_KEYS = {
                WEATHER: 'header_weather_data',
                WEATHER_TIME: 'header_weather_timestamp',
                THEME: 'theme'
            };

            const CACHE_DURATION = 10 * 60 * 1000; // 10 minutes

            // Store state in window to persist across Livewire navigation
            if (!window.HeaderModuleState) {
                window.HeaderModuleState = {
                    initialized: false,
                    dateTimeInterval: null,
                    weatherData: null,
                    lastWeatherFetch: null
                };
            }

            const state = window.HeaderModuleState;

            // ==================== THEME ====================
            function initTheme() {
                const html = document.documentElement;
                const stored = localStorage.getItem(CACHE_KEYS.THEME);
                const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
                const isDark = stored ? stored === 'dark' : prefersDark;

                html.classList.toggle('dark', isDark);
                updateThemeIcon(isDark);
            }

            function updateThemeIcon(isDark) {
                const lightIcon = document.getElementById('theme-toggle-light-icon');
                const darkIcon = document.getElementById('theme-toggle-dark-icon');

                if (!lightIcon || !darkIcon) return;

                if (isDark) {
                    darkIcon.style.transform = 'rotate(90deg) scale(0)';
                    lightIcon.style.transform = 'rotate(0deg) scale(1)';
                } else {
                    lightIcon.style.transform = 'rotate(90deg) scale(0)';
                    darkIcon.style.transform = 'rotate(0deg) scale(1)';
                }
            }

            function toggleTheme() {
                const html = document.documentElement;
                const isDark = html.classList.toggle('dark');
                localStorage.setItem(CACHE_KEYS.THEME, isDark ? 'dark' : 'light');
                updateThemeIcon(isDark);
            }

            // ==================== DATE & TIME ====================
            function updateDateTime() {
                const now = new Date();
                const dateEl = document.getElementById('current-date');
                const dateDisplay = document.getElementById('date-display');
                const timeEl = document.getElementById('current-time');

                if (dateEl && dateDisplay) {
                    const isoDate = now.toISOString().split('T')[0];
                    dateEl.setAttribute('datetime', isoDate);

                    const isMobile = window.innerWidth < 640;
                    const dateText = isMobile
                        ? now.toLocaleDateString('en-US', { month: 'numeric', day: 'numeric' })
                        : now.toLocaleDateString('en-US', { weekday: 'short', month: 'short', day: 'numeric' });

                    // Only update if changed (prevents unnecessary reflows)
                    if (dateDisplay.textContent !== dateText) {
                        dateDisplay.textContent = dateText;
                    }
                }

                if (timeEl) {
                    const time = now.toLocaleTimeString('en-US', {
                        hour: '2-digit',
                        minute: '2-digit',
                        hour12: true
                    });
                    const isoTime = now.toTimeString().split(' ')[0];

                    // Only update if changed
                    if (timeEl.textContent !== time) {
                        timeEl.setAttribute('datetime', isoTime);
                        timeEl.textContent = time;
                    }
                }
            }

            // ==================== WEATHER ====================
            function loadCachedWeather() {
                try {
                    const cached = localStorage.getItem(CACHE_KEYS.WEATHER);
                    const timestamp = localStorage.getItem(CACHE_KEYS.WEATHER_TIME);

                    if (cached && timestamp) {
                        const age = Date.now() - parseInt(timestamp);
                        if (age < CACHE_DURATION) {
                            state.weatherData = JSON.parse(cached);
                            displayWeather(state.weatherData);
                            return true;
                        }
                    }
                } catch (e) {
                    console.warn('Failed to load cached weather:', e);
                }
                return false;
            }

            async function fetchWeather(force = false) {
                // Prevent redundant fetches within 1 minute
                if (!force && state.lastWeatherFetch && (Date.now() - state.lastWeatherFetch < 60000)) {
                    if (state.weatherData) {
                        displayWeather(state.weatherData);
                    }
                    return;
                }

                if (!navigator.geolocation) {
                    showWeatherError();
                    return;
                }

                // Try to load from cache first
                if (!force && loadCachedWeather()) {
                    fetchWeatherInBackground();
                    return;
                }

                try {
                    const position = await new Promise((resolve, reject) => {
                        navigator.geolocation.getCurrentPosition(resolve, reject, {
                            timeout: 8000,
                            maximumAge: 5 * 60 * 1000,
                            enableHighAccuracy: false
                        });
                    });

                    await fetchWeatherData(position.coords);
                    state.lastWeatherFetch = Date.now();
                } catch (err) {
                    console.warn('Weather fetch failed:', err);
                    // Don't show error if we have cached data
                    if (!state.weatherData) {
                        showWeatherError();
                    }
                }
            }

            async function fetchWeatherInBackground() {
                try {
                    const position = await new Promise((resolve, reject) => {
                        navigator.geolocation.getCurrentPosition(resolve, reject, {
                            timeout: 8000,
                            maximumAge: 5 * 60 * 1000,
                            enableHighAccuracy: false
                        });
                    });
                    await fetchWeatherData(position.coords, true);
                    state.lastWeatherFetch = Date.now();
                } catch (err) {
                    console.debug('Background weather update failed');
                }
            }

            async function fetchWeatherData(coords, isBackground = false) {
                const { latitude, longitude } = coords;

                const response = await fetch(
                    `https://api.open-meteo.com/v1/forecast?latitude=${latitude}&longitude=${longitude}&current=temperature_2m,weather_code&temperature_unit=celsius&timezone=auto`,
                    { signal: AbortSignal.timeout(10000) }
                );

                if (!response.ok) throw new Error('Weather API error');

                const data = await response.json();
                const temp = Math.round(data.current.temperature_2m);
                const code = data.current.weather_code;

                const weatherInfo = getWeatherInfo(code);

                state.weatherData = {
                    icon: weatherInfo.icon,
                    temp,
                    description: weatherInfo.description
                };

                try {
                    localStorage.setItem(CACHE_KEYS.WEATHER, JSON.stringify(state.weatherData));
                    localStorage.setItem(CACHE_KEYS.WEATHER_TIME, Date.now().toString());
                } catch (e) {
                    console.warn('Failed to cache weather:', e);
                }

                displayWeather(state.weatherData, isBackground);
            }

            function getWeatherInfo(code) {
                const weatherMap = {
                    0: { icon: '☀️', description: 'Clear sky' },
                    1: { icon: '🌤️', description: 'Mainly clear' },
                    2: { icon: '⛅', description: 'Partly cloudy' },
                    3: { icon: '☁️', description: 'Overcast' },
                    45: { icon: '🌫️', description: 'Foggy' },
                    48: { icon: '🌫️', description: 'Foggy' },
                    51: { icon: '🌦️', description: 'Light drizzle' },
                    53: { icon: '🌦️', description: 'Drizzle' },
                    55: { icon: '🌦️', description: 'Heavy drizzle' },
                    61: { icon: '🌧️', description: 'Light rain' },
                    63: { icon: '🌧️', description: 'Rain' },
                    65: { icon: '🌧️', description: 'Heavy rain' },
                    71: { icon: '🌨️', description: 'Light snow' },
                    73: { icon: '🌨️', description: 'Snow' },
                    75: { icon: '🌨️', description: 'Heavy snow' },
                    77: { icon: '🌨️', description: 'Snow grains' },
                    80: { icon: '🌦️', description: 'Light showers' },
                    81: { icon: '🌧️', description: 'Showers' },
                    82: { icon: '🌧️', description: 'Heavy showers' },
                    85: { icon: '🌨️', description: 'Snow showers' },
                    86: { icon: '🌨️', description: 'Heavy snow' },
                    95: { icon: '⛈️', description: 'Thunderstorm' },
                    96: { icon: '⛈️', description: 'Thunderstorm with hail' },
                    99: { icon: '⛈️', description: 'Severe thunderstorm' }
                };

                return weatherMap[code] || { icon: '☁️', description: 'Cloudy' };
            }

            function displayWeather(data, smooth = false) {
                const loading = document.getElementById('weather-loading');
                const content = document.getElementById('weather-content');
                const icon = document.getElementById('weather-icon');
                const temp = document.getElementById('weather-temp');
                const desc = document.getElementById('weather-desc');
                const error = document.getElementById('weather-error');

                if (!content) return;

                error?.classList.add('hidden');
                error?.classList.remove('flex');

                if (icon) icon.textContent = data.icon;
                if (temp) temp.textContent = `${data.temp}°C`;
                if (desc) desc.textContent = data.description;

                // Always show content, never show loading on navigation
                loading?.classList.add('hidden');
                content.classList.remove('hidden');
                content.classList.add('flex');

                if (smooth) {
                    content.style.opacity = '0.5';
                    setTimeout(() => { content.style.opacity = '1'; }, 200);
                } else {
                    content.style.opacity = '1';
                }
            }

            function showWeatherError() {
                const loading = document.getElementById('weather-loading');
                const content = document.getElementById('weather-content');
                const error = document.getElementById('weather-error');

                loading?.classList.add('hidden');
                content?.classList.add('hidden');
                error?.classList.remove('hidden');
                error?.classList.add('flex');
            }

            // ==================== EVENT HANDLERS ====================
            function attachEventListeners() {
                const themeBtn = document.getElementById('theme-toggle');
                const weatherBtn = document.getElementById('weather-content');
                const mobileMenuToggle = document.getElementById('mobile-menu-toggle'); // Add this
                const mobileMenu = document.getElementById('mobile-menu'); // Add this
                const menuOpenIcon = document.getElementById('menu-open-icon'); // Add this
                const menuCloseIcon = document.getElementById('menu-close-icon'); // Add this

                if (themeBtn) {
                    const newThemeBtn = themeBtn.cloneNode(true);
                    themeBtn.replaceWith(newThemeBtn);
                    newThemeBtn.addEventListener('click', toggleTheme);
                }

                if (weatherBtn) {
                    const newWeatherBtn = weatherBtn.cloneNode(true);
                    weatherBtn.replaceWith(newWeatherBtn);
                    newWeatherBtn.addEventListener('click', () => {
                        fetchWeather(true);
                    });
                }

                // Add mobile menu toggle
                if (mobileMenuToggle && mobileMenu && menuOpenIcon && menuCloseIcon) {
                    const newToggle = mobileMenuToggle.cloneNode(true);
                    mobileMenuToggle.replaceWith(newToggle);
                    newToggle.addEventListener('click', () => {
                        const isOpen = !mobileMenu.classList.contains('hidden');
                        mobileMenu.classList.toggle('hidden');
                        menuOpenIcon.classList.toggle('hidden', isOpen);
                        menuCloseIcon.classList.toggle('hidden', !isOpen);
                    });
                }
            }

            // ==================== INITIALIZATION ====================
            function initialize() {
                initTheme();

                if (!state.initialized) {
                    console.debug('First initialization');

                    // Clear any existing interval
                    if (state.dateTimeInterval) {
                        clearInterval(state.dateTimeInterval);
                    }

                    // Start interval for continuous updates
                    state.dateTimeInterval = setInterval(updateDateTime, 1000);

                    // Fetch weather
                    fetchWeather();

                    state.initialized = true;
                } else {
                    console.debug('Already initialized - UI only');

                    //  ensure display is correct (no flicker)
                    if (state.weatherData) {
                        displayWeather(state.weatherData);
                    }
                }

                // Always reattach event listeners
                attachEventListeners();
            }

            // ==================== PUBLIC API ====================
            return {
                init: initialize,
                refresh: () => fetchWeather(true)
            };
        })();

        // Initialize
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', () => window.HeaderModule.init());
        } else {
            window.HeaderModule.init();
        }

        // Handle Livewire navigation
        document.addEventListener('livewire:navigated', () => {
            window.HeaderModule.init();
        });
    </script>

    @livewireScripts
</body>

</html>