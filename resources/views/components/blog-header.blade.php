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
    <header class="bg-white dark:bg-gray-900 border-b border-gray-200 dark:border-gray-700 sticky top-0 z-50 backdrop-blur-xl shadow-sm">
        {{-- Top Bar --}}
        <div class="border-b border-gray-100 dark:border-gray-800">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-12">
                    {{-- Left: Date & Time --}}
                    <div class="flex items-center gap-4 text-xs text-gray-600 dark:text-gray-400">
                        <div class="flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <span id="current-date" class="font-medium transition-opacity duration-300">Loading...</span>
                        </div>
                        <span class="text-gray-300 dark:text-gray-700">|</span>
                        <div class="flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span id="current-time" class="font-medium transition-opacity duration-300">--:--</span>
                        </div>
                    </div>

                    {{-- Center: Weather Widget --}}
                    <div id="weather-widget" class="hidden md:flex">
                        <div id="weather-loading" class="flex items-center gap-2 text-gray-500 dark:text-gray-400">
                            <svg class="animate-spin h-3.5 w-3.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                        </div>
                        <div id="weather-content" class="flex items-center gap-3 text-xs transition-opacity duration-300"></div>
                        <div id="weather-error" class="hidden text-xs text-red-600 dark:text-red-400"></div>
                    </div>

                    {{-- Right: Theme & Auth --}}
                    <div class="flex items-center gap-2">
                        {{-- Theme Toggle --}}
                        <button id="theme-toggle" 
                                type="button" 
                                aria-label="Toggle Theme"
                                class="p-1.5 rounded-lg hover:bg-gray-400 dark:hover:bg-gray-800 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-1">
                            <svg id="theme-toggle-light-icon" 
                                 class="w-4 h-4 hidden text-yellow-500" 
                                 fill="currentColor" 
                                 viewBox="0 0 20 20">
                                <path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zM4.22 4.22a1 1 0 011.415 0l.707.707a1 1 0 11-1.414 1.415l-.707-.707a1 1 0 010-1.415zM2 10a1 1 0 011-1h1a1 1 0 110 2H3a1 1 0 01-1-1zm8 5a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zm5.778-8.778a1 1 0 010 1.415l-.707.707a1 1 0 11-1.415-1.414l.707-.708a1 1 0 011.415 0zM16 9a1 1 0 011 1v0a1 1 0 11-2 0 1 1 0 011-1zM4.22 15.778a1 1 0 010-1.415l.707-.707a1 1 0 011.415 1.414l-.707.708a1 1 0 01-1.415 0zM15.778 15.778a1 1 0 00-1.415 0l-.707.707a1 1 0 101.414 1.414l.708-.707a1 1 0 000-1.414zM10 6a4 4 0 100 8 4 4 0 000-8z" />
                            </svg>
                            <svg id="theme-toggle-dark-icon" 
                                 class="w-4 h-4 hidden text-gray-800" 
                                 fill="currentColor" 
                                 viewBox="0 0 20 20">
                                <path d="M17.293 13.293A8 8 0 116.707 2.707a7 7 0 1010.586 10.586z" />
                            </svg>
                        </button>

                        @guest
                            <a href="{{ route('login') }}" 
                               class="text-xs font-medium text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition-colors">
                                Sign In
                            </a>
                        @endguest
                    </div>
                </div>
            </div>
        </div>

        {{-- Main Header --}}
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between py-6">
                
                {{-- Logo Section --}}
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="group flex items-center gap-4" wire:navigate>
                        <div class="relative">
                            <div class="absolute inset-0 bg-linear-to-r from-blue-600 to-purple-600 rounded-2xl blur opacity-40 group-hover:opacity-60 transition-opacity"></div>
                            <div class="relative w-14 h-14 rounded-2xl bg-linear-to-br from-blue-600 via-purple-600 to-pink-600 flex items-center justify-center shadow-lg group-hover:shadow-xl transition-shadow duration-300">
                                <span class="text-2xl font-black text-white">B</span>
                            </div>
                        </div>
                        <div class="hidden sm:block">
                            <h1 class="text-2xl font-black text-gray-900 dark:text-white tracking-tight group-hover:text-transparent group-hover:bg-linear-to-r group-hover:from-blue-600 group-hover:to-purple-600 group-hover:bg-clip-text transition-all duration-300">
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
                       class="group relative px-5 py-2.5 rounded-xl text-sm font-semibold text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition-colors duration-200 {{ request()->routeIs('home') ? 'text-blue-600 dark:text-blue-400' : '' }}"
                       wire:navigate>
                        <span class="relative z-10 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                            </svg>
                            Home
                        </span>
                        @if(request()->routeIs('home'))
                            <span class="absolute inset-0 bg-blue-50 dark:bg-blue-900/20 rounded-xl"></span>
                        @endif
                    </a>
                    <a href="{{ route('public.posts.index') }}" 
                       class="group relative px-5 py-2.5 rounded-xl text-sm font-semibold text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition-colors duration-200 {{ request()->routeIs('public.posts.*') ? 'text-blue-600 dark:text-blue-400' : '' }}"
                       wire:navigate>
                        <span class="relative z-10 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                            </svg>
                            Articles
                        </span>
                        @if(request()->routeIs('public.posts.*'))
                            <span class="absolute inset-0 bg-blue-50 dark:bg-blue-900/20 rounded-xl"></span>
                        @endif
                    </a>
                    <a href="{{ route('about') }}" 
                       class="group relative px-5 py-2.5 rounded-xl text-sm font-semibold text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition-colors duration-200 {{ request()->routeIs('about') ? 'text-blue-600 dark:text-blue-400' : '' }}"
                       wire:navigate>
                        <span class="relative z-10 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            About
                        </span>
                        @if(request()->routeIs('about'))
                            <span class="absolute inset-0 bg-blue-50 dark:bg-blue-900/20 rounded-xl"></span>
                        @endif
                    </a>
                    <a href="{{ route('contact') }}" 
                       class="group relative px-5 py-2.5 rounded-xl text-sm font-semibold text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition-colors duration-200 {{ request()->routeIs('contact') ? 'text-blue-600 dark:text-blue-400' : '' }}"
                       wire:navigate>
                        <span class="relative z-10 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                            Contact
                        </span>
                        @if(request()->routeIs('contact'))
                            <span class="absolute inset-0 bg-blue-50 dark:bg-blue-900/20 rounded-xl"></span>
                        @endif
                    </a>
                </nav>

                {{-- Right Actions --}}
                <div class="flex items-center gap-3">
                    @auth
                        @php
                            $user = auth()->user();
                            $isAdmin = $user->hasAnyRole(['admin', 'editor', 'writer']);
                            $isRegularUser = $user->hasRole('user') && !$user->hasAnyRole(['admin', 'editor', 'writer']);
                        @endphp

                        {{-- User Menu (Desktop) --}}
                        <div class="hidden md:block relative" x-data="{ open: false }">
                            <button @click="open = !open" 
                                    @click.away="open = false"
                                    class="flex items-center gap-3 px-4 py-2.5 rounded-xl hover:bg-gray-100 dark:hover:bg-gray-800 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 group">
                                <div class="relative">
                                    <div class="w-10 h-10 rounded-xl bg-linear-to-br from-purple-500 via-pink-500 to-red-500 flex items-center justify-center text-white font-bold shadow-md group-hover:shadow-lg transition-shadow">
                                        {{ $user->initials() }}
                                    </div>
                                    <div class="absolute -bottom-1 -right-1 w-4 h-4 bg-green-500 border-2 border-white dark:border-gray-900 rounded-full"></div>
                                </div>
                                <div class="hidden lg:block text-left">
                                    <p class="text-sm font-semibold text-gray-900 dark:text-white leading-none">{{ Str::limit($user->name, 20) }}</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">
                                        {{ $user->getRoleNames()->first() ?? 'User' }}
                                    </p>
                                </div>
                                <svg class="w-4 h-4 text-gray-400 transition-transform duration-200" 
                                     :class="{ 'rotate-180': open }"
                                     fill="none" 
                                     stroke="currentColor" 
                                     viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>

                            {{-- Dropdown --}}
                            <div x-show="open" 
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="opacity-0 scale-95 translate-y-2"
                                 x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                                 x-transition:leave="transition ease-in duration-150"
                                 x-transition:leave-start="opacity-100 scale-100"
                                 x-transition:leave-end="opacity-0 scale-95"
                                 class="absolute right-0 mt-3 w-72 bg-white dark:bg-gray-800 rounded-2xl shadow-2xl border border-gray-200 dark:border-gray-700 overflow-hidden z-50"
                                 style="display: none;">
                                
                                {{-- User Info Card --}}
                                <div class="p-5 bg-linear-to-br from-blue-50 to-purple-50 dark:from-blue-900/20 dark:to-purple-900/20 border-b border-gray-200 dark:border-gray-700">
                                    <div class="flex items-center gap-4">
                                        <div class="relative">
                                            <div class="w-14 h-14 rounded-xl bg-linear-to-br from-purple-500 via-pink-500 to-red-500 flex items-center justify-center text-white font-bold text-lg shadow-lg">
                                                {{ $user->initials() }}
                                            </div>
                                            <div class="absolute -bottom-1 -right-1 w-5 h-5 bg-green-500 border-3 border-white dark:border-gray-800 rounded-full"></div>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-base font-bold text-gray-900 dark:text-white truncate">{{ $user->name }}</p>
                                            <p class="text-xs text-gray-600 dark:text-gray-400 truncate">{{ $user->email }}</p>
                                            <span class="inline-flex items-center gap-1 mt-1 px-2 py-0.5 bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 rounded-full text-xs font-medium">
                                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
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
                                           class="flex items-center gap-3 px-5 py-3 text-sm font-medium text-gray-700 dark:text-gray-200 hover:bg-blue-50 dark:hover:bg-blue-900/20 hover:text-blue-600 dark:hover:text-blue-400 transition-colors"
                                           wire:navigate>
                                            <div class="w-8 h-8 rounded-lg bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center">
                                                <svg class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                                                </svg>
                                            </div>
                                            <span>Dashboard</span>
                                        </a>
                                        <a href="{{ route('admin.profile.edit') }}" 
                                           class="flex items-center gap-3 px-5 py-3 text-sm font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors"
                                           wire:navigate>
                                            <div class="w-8 h-8 rounded-lg bg-gray-100 dark:bg-gray-700 flex items-center justify-center">
                                                <svg class="w-4 h-4 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                </svg>
                                            </div>
                                            <span>Settings</span>
                                        </a>
                                    @elseif($isRegularUser)
                                        <a href="{{ route('user.profile.edit') }}" 
                                           class="flex items-center gap-3 px-5 py-3 text-sm font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors"
                                           wire:navigate>
                                            <div class="w-8 h-8 rounded-lg bg-gray-100 dark:bg-gray-700 flex items-center justify-center">
                                                <svg class="w-4 h-4 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                </svg>
                                            </div>
                                            <span>Settings</span>
                                        </a>
                                    @endif
                                </div>

                                {{-- Logout --}}
                                <div class="border-t border-gray-200 dark:border-gray-700 p-2">
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" 
                                                class="flex items-center gap-3 w-full px-5 py-3 text-sm font-medium text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition-colors">
                                            <div class="w-8 h-8 rounded-lg bg-red-100 dark:bg-red-900/30 flex items-center justify-center">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
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
                        <div class="hidden md:flex items-center gap-3">
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" 
                                   class="inline-flex items-center gap-2 px-6 py-2.5 bg-linear-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white font-semibold rounded-xl shadow-md hover:shadow-lg transition-all duration-200 transform hover:scale-105">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                                    </svg>
                                    Get Started
                                </a>
                            @endif
                        </div>
                    @endauth

                    {{-- Mobile Menu Toggle --}}
                    <button id="mobile-menu-toggle" 
                            type="button" 
                            aria-label="Toggle Menu"
                            class="lg:hidden p-2.5 rounded-xl hover:bg-gray-100 dark:hover:bg-gray-800 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <svg id="menu-open-icon" class="w-6 h-6 text-gray-700 dark:text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                        <svg id="menu-close-icon" class="w-6 h-6 text-gray-700 dark:text-gray-200 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        {{-- Mobile Menu --}}
        <div id="mobile-menu" class="lg:hidden hidden border-t border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900">
            <nav class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 space-y-2">
                {{-- Mobile Weather --}}
                <div id="weather-widget-mobile" class="mb-4 p-4 bg-linear-to-r from-blue-50 to-purple-50 dark:from-blue-900/20 dark:to-purple-900/20 rounded-xl border border-gray-200 dark:border-gray-700 transition-opacity duration-300">
                    <div id="weather-mobile-content" class="text-sm"></div>
                </div>

                {{-- Navigation Links --}}
                <a href="{{ route('home') }}" 
                   class="flex items-center gap-4 px-4 py-4 text-base font-semibold rounded-xl transition-all duration-200 {{ request()->routeIs('home') ? 'bg-blue-50 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400' : 'text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-800' }}"
                   wire:navigate>
                    <div class="w-10 h-10 rounded-lg {{ request()->routeIs('home') ? 'bg-blue-100 dark:bg-blue-900/30' : 'bg-gray-100 dark:bg-gray-800' }} flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                    </div>
                    <span>Home</span>
                </a>
                <a href="{{ route('public.posts.index') }}" 
                   class="flex items-center gap-4 px-4 py-4 text-base font-semibold rounded-xl transition-all duration-200 {{ request()->routeIs('public.posts.*') ? 'bg-blue-50 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400' : 'text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-800' }}"
                   wire:navigate>
                    <div class="w-10 h-10 rounded-lg {{ request()->routeIs('public.posts.*') ? 'bg-blue-100 dark:bg-blue-900/30' : 'bg-gray-100 dark:bg-gray-800' }} flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                        </svg>
                    </div>
                    <span>Articles</span>
                </a>
                <a href="{{ route('about') }}" 
                   class="flex items-center gap-4 px-4 py-4 text-base font-semibold rounded-xl transition-all duration-200 {{ request()->routeIs('about') ? 'bg-blue-50 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400' : 'text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-800' }}"
                   wire:navigate>
                    <div class="w-10 h-10 rounded-lg {{ request()->routeIs('about') ? 'bg-blue-100 dark:bg-blue-900/30' : 'bg-gray-100 dark:bg-gray-800' }} flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <span>About</span>
                </a>
                <a href="{{ route('contact') }}" 
                   class="flex items-center gap-4 px-4 py-4 text-base font-semibold rounded-xl transition-all duration-200 {{ request()->routeIs('contact') ? 'bg-blue-50 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400' : 'text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-800' }}"
                   wire:navigate>
                    <div class="w-10 h-10 rounded-lg {{ request()->routeIs('contact') ? 'bg-blue-100 dark:bg-blue-900/30' : 'bg-gray-100 dark:bg-gray-800' }} flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <span>Contact</span>
                </a>

                @auth
                    @php
                        $user = auth()->user();
                        $isAdmin = $user->hasAnyRole(['admin', 'editor', 'writer']);
                        $isRegularUser = $user->hasRole('user') && !$user->hasAnyRole(['admin', 'editor', 'writer']);
                    @endphp

                    {{-- User Section --}}
                    <div class="pt-4 border-t border-gray-200 dark:border-gray-700 mt-4">
                        <div class="p-4 bg-linear-to-br from-purple-50 to-pink-50 dark:from-purple-900/20 dark:to-pink-900/20 rounded-xl mb-3">
                            <div class="flex items-center gap-4">
                                <div class="relative">
                                    <div class="w-12 h-12 rounded-xl bg-linear-to-br from-purple-500 via-pink-500 to-red-500 flex items-center justify-center text-white font-bold shadow-lg">
                                        {{ $user->initials() }}
                                    </div>
                                    <div class="absolute -bottom-1 -right-1 w-4 h-4 bg-green-500 border-2 border-white dark:border-gray-900 rounded-full"></div>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-bold text-gray-900 dark:text-white truncate">{{ $user->name }}</p>
                                    <p class="text-xs text-gray-600 dark:text-gray-400 truncate">{{ $user->email }}</p>
                                </div>
                            </div>
                        </div>

                        @if($isAdmin)
                            <a href="{{ route('dashboard') }}" 
                               class="flex items-center gap-4 px-4 py-4 text-base font-semibold text-blue-600 dark:text-blue-400 hover:bg-blue-50 dark:hover:bg-blue-900/20 rounded-xl transition-all"
                               wire:navigate>
                                <div class="w-10 h-10 rounded-lg bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                                    </svg>
                                </div>
                                <span>Dashboard</span>
                            </a>
                            <a href="{{ route('admin.profile.edit') }}" 
                               class="flex items-center gap-4 px-4 py-4 text-base font-semibold text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-800 rounded-xl transition-all"
                               wire:navigate>
                                <div class="w-10 h-10 rounded-lg bg-gray-100 dark:bg-gray-800 flex items-center justify-center">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                </div>
                                <span>Settings</span>
                            </a>
                        @elseif($isRegularUser)
                            <a href="{{ route('user.profile.edit') }}" 
                               class="flex items-center gap-4 px-4 py-4 text-base font-semibold text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-800 rounded-xl transition-all"
                               wire:navigate>
                                <div class="w-10 h-10 rounded-lg bg-gray-100 dark:bg-gray-800 flex items-center justify-center">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                </div>
                                <span>Settings</span>
                            </a>
                        @endif

                        <form method="POST" action="{{ route('logout') }}" class="mt-2">
                            @csrf
                            <button type="submit" 
                                    class="flex items-center gap-4 w-full px-4 py-4 text-base font-semibold text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-xl transition-all text-left">
                                <div class="w-10 h-10 rounded-lg bg-red-100 dark:bg-red-900/30 flex items-center justify-center">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                    </svg>
                                </div>
                                <span>Logout</span>
                            </button>
                        </form>
                    </div>
                @else
                    <div class="pt-4 border-t border-gray-200 dark:border-gray-700 mt-4 space-y-3">
                        <a href="{{ route('login') }}" 
                           class="flex items-center justify-center gap-2 w-full px-6 py-4 text-base font-semibold text-gray-700 dark:text-gray-200 bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 rounded-xl transition-all">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                            </svg>
                            Log in
                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" 
                               class="flex items-center justify-center gap-2 w-full px-6 py-4 text-base font-semibold text-white bg-linear-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 rounded-xl shadow-lg transition-all">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                                </svg>
                                Get Started
                            </a>
                        @endif
                    </div>
                @endauth
            </nav>
        </div>
    </header>

    {{-- Main Content --}}
    {{ $slot }}

    {{-- Scripts --}}
    <script>
        // Global state to prevent re-initialization
        window.headerInitialized = window.headerInitialized || false;
        window.dateTimeInterval = window.dateTimeInterval || null;
        window.weatherData = window.weatherData || null;

        // Immediate theme application
        (function() {
            const theme = localStorage.getItem('theme') || 
                         (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light');
            if (theme === 'dark') document.documentElement.classList.add('dark');
        })();

        // Smooth Date & Time Update
        function updateDateTime() {
            const now = new Date();
            const dateEl = document.getElementById('current-date');
            const timeEl = document.getElementById('current-time');
            
            if (dateEl) {
                const newDate = now.toLocaleDateString('en-US', { 
                    weekday: 'short', 
                    year: 'numeric', 
                    month: 'short', 
                    day: 'numeric' 
                });
                if (dateEl.textContent !== newDate) {
                    dateEl.style.opacity = '0.5';
                    setTimeout(() => {
                        dateEl.textContent = newDate;
                        dateEl.style.opacity = '1';
                    }, 150);
                }
            }
            
            if (timeEl) {
                const newTime = now.toLocaleTimeString('en-US', { 
                    hour: '2-digit', 
                    minute: '2-digit'
                });
                if (timeEl.textContent !== newTime) {
                    timeEl.textContent = newTime;
                }
            }
        }

        // Weather with caching
        async function fetchWeather() {
            // Return cached data if available and less than 10 minutes old
            if (window.weatherData && (Date.now() - window.weatherData.timestamp < 600000)) {
                displayWeather(window.weatherData);
                return;
            }

            const widget = document.getElementById('weather-widget');
            const loading = document.getElementById('weather-loading');
            const content = document.getElementById('weather-content');
            const mobileContent = document.getElementById('weather-mobile-content');

            try {
                const position = await new Promise((resolve, reject) => {
                    navigator.geolocation.getCurrentPosition(resolve, reject, {
                        timeout: 10000,
                        maximumAge: 300000
                    });
                });

                const { latitude, longitude } = position.coords;
                
                const response = await fetch(
                    `https://api.met.no/weatherapi/locationforecast/2.0/compact?lat=${latitude}&lon=${longitude}`,
                    { headers: { 'User-Agent': 'TheBrief/1.0' } }
                );

                if (!response.ok) throw new Error('Weather API failed');

                const data = await response.json();
                const current = data.properties.timeseries[0];
                const temp = Math.round(current.data.instant.details.air_temperature);
                const symbol = current.data.next_1_hours?.summary.symbol_code || 'cloudy';

                const icons = {
                    'clear': '☀️',
                    'cloudy': '☁️',
                    'rain': '🌧️',
                    'snow': '❄️',
                    'thunder': '⛈️'
                };

                const icon = Object.keys(icons).find(key => symbol.includes(key)) ? icons[Object.keys(icons).find(key => symbol.includes(key))] : '☁️';

                // Cache the weather data
                window.weatherData = {
                    icon,
                    temp,
                    timestamp: Date.now()
                };

                displayWeather(window.weatherData);

            } catch (err) {
                console.error('Weather error:', err);
                loading?.classList.add('hidden');
            }
        }

        function displayWeather(data) {
            const loading = document.getElementById('weather-loading');
            const content = document.getElementById('weather-content');
            const mobileContent = document.getElementById('weather-mobile-content');
            const widget = document.getElementById('weather-widget');

            const html = `
                <div class="flex items-center gap-2">
                    <span class="text-lg">${data.icon}</span>
                    <span class="font-semibold text-gray-900 dark:text-white">${data.temp}°C</span>
                </div>
            `;

            loading?.classList.add('hidden');
            
            if (content) {
                content.style.opacity = '0';
                setTimeout(() => {
                    content.innerHTML = html;
                    content.classList.remove('hidden');
                    content.style.opacity = '1';
                }, 150);
            }
            
            if (mobileContent) {
                mobileContent.innerHTML = `<div class="text-center"><span class="text-2xl">${data.icon}</span> <span class="font-bold">${data.temp}°C</span></div>`;
            }
            
            widget?.classList.remove('hidden');
        }

        // Theme toggle helper function
        function updateThemeIcons(isDark) {
            const lightIcon = document.getElementById('theme-toggle-light-icon');
            const darkIcon = document.getElementById('theme-toggle-dark-icon');
            
            if (lightIcon && darkIcon) {
                // When in dark mode, show sun icon (to switch to light)
                // When in light mode, show moon icon (to switch to dark)
                if (isDark) {
                    lightIcon.classList.remove('hidden');
                    darkIcon.classList.add('hidden');
                } else {
                    lightIcon.classList.add('hidden');
                    darkIcon.classList.remove('hidden');
                }
            }
        }

        // Initialize or re-attach event listeners
        function initializeHeader() {
            // Only set up intervals once
            if (!window.headerInitialized) {
                updateDateTime();
                window.dateTimeInterval = setInterval(updateDateTime, 60000);
                fetchWeather();
                window.headerInitialized = true;
            } else {
                // Just update the display immediately on navigation
                updateDateTime();
                if (window.weatherData) {
                    displayWeather(window.weatherData);
                }
            }

            const html = document.documentElement;
            const btn = document.getElementById('theme-toggle');

            // Set initial icon state
            const stored = localStorage.getItem('theme');
            const preferDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            const isDark = stored ? stored === 'dark' : preferDark;
            updateThemeIcons(isDark);

            // Remove old listeners and add new ones
            if (btn) {
                const newBtn = btn.cloneNode(true);
                btn.parentNode.replaceChild(newBtn, btn);
                
                newBtn.addEventListener('click', function() {
                    const nowDark = html.classList.contains('dark');
                    const newDark = !nowDark;
                    
                    html.classList.toggle('dark', newDark);
                    localStorage.setItem('theme', newDark ? 'dark' : 'light');
                    
                    // Update icons after toggle
                    updateThemeIcons(newDark);
                });
            }

            // Mobile menu
            const toggle = document.getElementById('mobile-menu-toggle');
            const menu = document.getElementById('mobile-menu');
            
            if (toggle && menu) {
                const newToggle = toggle.cloneNode(true);
                toggle.parentNode.replaceChild(newToggle, toggle);
                
                newToggle.addEventListener('click', () => {
                    menu.classList.toggle('hidden');
                    const openIcon = document.getElementById('menu-open-icon');
                    const closeIcon = document.getElementById('menu-close-icon');
                    openIcon?.classList.toggle('hidden');
                    closeIcon?.classList.toggle('hidden');
                });
            }
        }

        // Initialize on load
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initializeHeader);
        } else {
            initializeHeader();
        }

        // Re-initialize on Livewire navigation
        document.addEventListener('livewire:navigated', function() {
            initializeHeader();
        });
    </script>

    @livewireScripts
</body>
</html>