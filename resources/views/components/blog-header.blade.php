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
    <header class="bg-white dark:bg-gray-900 border-b border-gray-200 dark:border-gray-700 shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                
                {{-- Logo --}}
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="flex items-center gap-3 hover:opacity-80 transition-opacity duration-200" wire:navigate>
                        <div class="w-10 h-10 rounded-full bg-gradient-to-r from-blue-500 to-purple-500 text-white flex items-center justify-center font-bold shadow-md">
                            B
                        </div>
                        <div class="hidden sm:block">
                            <h1 class="text-lg font-bold text-gray-900 dark:text-white">{{ $title ?? 'The Brief' }}</h1>
                            <p class="text-xs text-gray-500 dark:text-gray-400">News &amp; Analysis</p>
                        </div>
                    </a>
                </div>

                {{-- Desktop Navigation --}}
                <nav class="hidden md:flex items-center space-x-6">
                    <a href="{{ route('public.posts.index') }}" 
                       class="text-gray-700 dark:text-gray-200 hover:text-blue-600 dark:hover:text-blue-400 transition-colors duration-200 font-medium"
                       wire:navigate>
                        All Posts
                    </a>
                    <a href="{{ route('public.posts.index', ['category' => 'politics']) }}" 
                       class="text-gray-700 dark:text-gray-200 hover:text-blue-600 dark:hover:text-blue-400 transition-colors duration-200 font-medium"
                       wire:navigate>
                        Politics
                    </a>
                    <a href="{{ route('public.posts.index', ['category' => 'tech']) }}" 
                       class="text-gray-700 dark:text-gray-200 hover:text-blue-600 dark:hover:text-blue-400 transition-colors duration-200 font-medium"
                       wire:navigate>
                        Tech
                    </a>
                    <a href="{{ route('public.posts.index', ['category' => 'culture']) }}" 
                       class="text-gray-700 dark:text-gray-200 hover:text-blue-600 dark:hover:text-blue-400 transition-colors duration-200 font-medium"
                       wire:navigate>
                        Culture
                    </a>
                </nav>

                {{-- Right Side Actions --}}
                <div class="flex items-center gap-3">
                    
                    {{-- Theme Toggle --}}
                    <button id="theme-toggle" 
                            type="button" 
                            aria-label="Toggle Theme"
                            class="p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-all duration-200">
                        <svg id="theme-toggle-light-icon" 
                             class="w-5 h-5 hidden text-yellow-500" 
                             fill="currentColor" 
                             viewBox="0 0 20 20">
                            <path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zM4.22 4.22a1 1 0 011.415 0l.707.707a1 1 0 11-1.414 1.415l-.707-.707a1 1 0 010-1.415zM2 10a1 1 0 011-1h1a1 1 0 110 2H3a1 1 0 01-1-1zm8 5a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zm5.778-8.778a1 1 0 010 1.415l-.707.707a1 1 0 11-1.415-1.414l.707-.708a1 1 0 011.415 0zM16 9a1 1 0 011 1v0a1 1 0 11-2 0 1 1 0 011-1zM4.22 15.778a1 1 0 010-1.415l.707-.707a1 1 0 011.415 1.414l-.707.708a1 1 0 01-1.415 0zM15.778 15.778a1 1 0 00-1.415 0l-.707.707a1 1 0 101.414 1.414l.708-.707a1 1 0 000-1.414zM10 6a4 4 0 100 8 4 4 0 000-8z" />
                        </svg>
                        <svg id="theme-toggle-dark-icon" 
                             class="w-5 h-5 hidden text-gray-200" 
                             fill="currentColor" 
                             viewBox="0 0 20 20">
                            <path d="M17.293 13.293A8 8 0 116.707 2.707a7 7 0 1010.586 10.586z" />
                        </svg>
                    </button>

                    {{-- Auth Buttons --}}
                    @auth
                        @php
                            $user = auth()->user();
                            // ✅ Same logic as middleware
                            $isAdmin = $user->hasAnyRole(['admin', 'editor', 'writer']);
                            $isRegularUser = $user->hasRole('user') && !$user->hasAnyRole(['admin', 'editor', 'writer']);
                        @endphp

                        <!--@if($isAdmin)
                            {{-- Admin: Dashboard Button --}}
                            <a href="{{ route('dashboard') }}" 
                               class="hidden sm:inline-flex px-4 py-2 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-lg transition-colors duration-200 shadow-sm"
                               wire:navigate>
                                Dashboard
                            </a>
                        @endif -->

                        {{-- User Menu Dropdown --}}
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" 
                                    @click.away="open = false"
                                    class="flex items-center gap-2 p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200">
                                <div class="w-8 h-8 rounded-full bg-gradient-to-r from-purple-500 to-pink-500 text-white flex items-center justify-center font-semibold text-sm">
                                    {{ $user->initials() }}
                                </div>
                                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" 
                                     fill="none" 
                                     stroke="currentColor" 
                                     viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>

                            {{-- Dropdown Menu --}}
                            <div x-show="open" 
                                 x-transition
                                 class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 rounded-lg shadow-lg border border-gray-200 dark:border-gray-700 py-1 z-50"
                                 style="display: none;">
                                
                                {{-- User Info --}}
                                <div class="px-4 py-3 border-b border-gray-200 dark:border-gray-700">
                                    <p class="text-sm font-medium text-gray-900 dark:text-white truncate">{{ $user->name }}</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 truncate">{{ $user->email }}</p>
                                </div>

                                {{-- Menu Items --}}
                                @if($isAdmin)
                                    <a href="{{ route('dashboard') }}" 
                                       class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700"
                                       wire:navigate>
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                                        </svg>
                                        Dashboard
                                    </a>
                                    <a href="{{ route('admin.profile.edit') }}" 
                                       class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700"
                                       wire:navigate>
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                        Settings
                                    </a>
                                @elseif($isRegularUser)
                                    <a href="{{ route('user.profile.edit') }}" 
                                       class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700"
                                       wire:navigate>
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                        Settings
                                    </a>
                                @endif

                                {{-- Logout --}}
                                <div class="border-t border-gray-200 dark:border-gray-700 mt-1 pt-1">
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" 
                                                class="flex items-center gap-2 w-full px-4 py-2 text-sm text-red-600 dark:text-red-400 hover:bg-gray-100 dark:hover:bg-gray-700 text-left">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                            </svg>
                                            Logout
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>

                    @else
                        {{-- Guest Users --}}
                        <a href="{{ route('login') }}" 
                           class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-200 hover:text-blue-600 dark:hover:text-blue-400 transition-colors duration-200">
                            Log in
                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" 
                               class="px-4 py-2 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-lg transition-colors duration-200 shadow-sm">
                                Sign up
                            </a>
                        @endif
                    @endauth

                    {{-- Mobile Menu Toggle --}}
                    <button id="mobile-menu-toggle" 
                            type="button" 
                            aria-label="Toggle Menu"
                            class="md:hidden p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-all duration-200">
                        <svg class="w-6 h-6 text-gray-700 dark:text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                </div>
            </div>

            {{-- Mobile Menu --}}
            <div id="mobile-menu" class="md:hidden hidden border-t border-gray-200 dark:border-gray-700 py-4">
                <nav class="flex flex-col space-y-2">
                    <a href="{{ route('public.posts.index') }}" 
                       class="px-4 py-2 text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg"
                       wire:navigate>
                        All Posts
                    </a>
                    <a href="{{ route('public.posts.index', ['category' => 'politics']) }}" 
                       class="px-4 py-2 text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg"
                       wire:navigate>
                        Politics
                    </a>
                    <a href="{{ route('public.posts.index', ['category' => 'tech']) }}" 
                       class="px-4 py-2 text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg"
                       wire:navigate>
                        Tech
                    </a>
                    <a href="{{ route('public.posts.index', ['category' => 'culture']) }}" 
                       class="px-4 py-2 text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg"
                       wire:navigate>
                        Culture
                    </a>

                    @auth
                        @php
                            $user = auth()->user();
                            $isAdmin = $user->hasAnyRole(['admin', 'editor', 'writer']);
                            $isRegularUser = $user->hasRole('user') && !$user->hasAnyRole(['admin', 'editor', 'writer']);
                        @endphp

                        <div class="border-t border-gray-200 dark:border-gray-700 my-2 pt-2">
                            @if($isAdmin)
                                <a href="{{ route('dashboard') }}" 
                                   class="px-4 py-2 text-blue-600 dark:text-blue-400 font-semibold block hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg"
                                   wire:navigate>
                                    Dashboard
                                </a>
                                <a href="{{ route('admin.profile.edit') }}" 
                                   class="px-4 py-2 text-gray-700 dark:text-gray-200 block hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg"
                                   wire:navigate>
                                    Settings
                                </a>
                            @elseif($isRegularUser)
                                <a href="{{ route('user.profile.edit') }}" 
                                   class="px-4 py-2 text-blue-600 dark:text-blue-400 font-semibold block hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg"
                                   wire:navigate>
                                    Settings
                                </a>
                            @endif

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" 
                                        class="w-full text-left px-4 py-2 text-red-600 dark:text-red-400 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg">
                                    Logout
                                </button>
                            </form>
                        </div>
                    @else
                        <div class="border-t border-gray-200 dark:border-gray-700 my-2 pt-2">
                            <a href="{{ route('login') }}" 
                               class="px-4 py-2 text-gray-700 dark:text-gray-200 block hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg">
                                Log in
                            </a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" 
                                   class="px-4 py-2 text-blue-600 dark:text-blue-400 font-semibold block hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg">
                                    Sign up
                                </a>
                            @endif
                        </div>
                    @endauth
                </nav>
            </div>
        </div>
    </header>

    {{-- Main Content --}}
    <div class="bg-gray-50 dark:bg-gray-900 ">
        <div class="max-w-7xl mx-auto px-2 sm:px-2 lg:px-2 py-2">
            {{ $slot }}
        </div>
    </div>

    {{-- Scripts --}}
    <script>
        // Theme Toggle
        (function () {
            const html = document.documentElement;
            const btn = document.getElementById('theme-toggle');
            if (!btn) return;

            const lightIcon = document.getElementById('theme-toggle-light-icon');
            const darkIcon = document.getElementById('theme-toggle-dark-icon');

            function setIcons(isDark) {
                if (isDark) {
                    darkIcon.classList.remove('hidden');
                    lightIcon.classList.add('hidden');
                } else {
                    lightIcon.classList.remove('hidden');
                    darkIcon.classList.add('hidden');
                }
            }

            const stored = localStorage.getItem('theme');
            const preferDark = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
            let isDark = stored ? stored === 'dark' : preferDark;

            if (isDark) html.classList.add('dark');
            else html.classList.remove('dark');

            setIcons(isDark);

            btn.addEventListener('click', function () {
                const nowDark = html.classList.contains('dark');
                const newDark = !nowDark;
                if (newDark) html.classList.add('dark');
                else html.classList.remove('dark');
                localStorage.setItem('theme', newDark ? 'dark' : 'light');
                setIcons(newDark);
            });
        })();

        // Mobile Menu Toggle
        (function () {
            const toggle = document.getElementById('mobile-menu-toggle');
            const menu = document.getElementById('mobile-menu');
            if (toggle && menu) {
                toggle.addEventListener('click', () => {
                    menu.classList.toggle('hidden');
                });
            }
        })();
    </script>

    @livewireScripts
</body>

</html>