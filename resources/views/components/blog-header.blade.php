<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('partials.head') {{-- contains @vite([...]) --}}
    @livewireStyles
</head>
<body class="antialiased bg-gray-50 dark:bg-gray-900">

<div> {{-- single root wrapper for the component --}}
    <header class="bg-white dark:bg-gray-900 border-b border-gray-200 dark:border-gray-700 shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-6">
            <div class="flex items-center justify-between h-20">
                <div class="flex items-center gap-4">
                    <a href="{{ url('/') }}" class="flex items-center gap-3 hover:opacity-80 transition-opacity duration-200">
                        <div class="w-12 h-12 rounded-full bg-gradient-to-r from-blue-500 to-purple-500 text-white flex items-center justify-center font-bold shadow-md">
                            B
                        </div>
                        <div>
                            <h1 class="text-lg font-bold text-gray-900 dark:text-white">{{ $title ?? 'The Brief' }}</h1>
                            <p class="text-xs text-gray-500 dark:text-gray-400">News &amp; Analysis</p>
                        </div>
                    </a>
                </div>

                {{-- center slot for optional search or other content --}}
                <div class="flex-1 mx-6 hidden lg:block">
                    @isset($center)
                        {{ $center }}
                    @endisset
                </div>

                <nav class="hidden md:flex items-center space-x-6">
                    <a href="{{ route('posts.index') }}" class="text-gray-700 dark:text-gray-200 hover:text-blue-600 dark:hover:text-blue-400 transition-colors duration-200 font-medium">All Posts</a>
                    <a href="{{ route('posts.index', ['category' => 'politics']) }}" class="text-gray-700 dark:text-gray-200 hover:text-blue-600 dark:hover:text-blue-400 transition-colors duration-200 font-medium">Politics</a>
                    <a href="{{ route('posts.index', ['category' => 'tech']) }}" class="text-gray-700 dark:text-gray-200 hover:text-blue-600 dark:hover:text-blue-400 transition-colors duration-200 font-medium">Tech</a>
                    <a href="{{ route('posts.index', ['category' => 'culture']) }}" class="text-gray-700 dark:text-gray-200 hover:text-blue-600 dark:hover:text-blue-400 transition-colors duration-200 font-medium">Culture</a>
                </nav>

                <div class="ml-4 flex items-center gap-3">
                    <a href="#" class="text-sm text-gray-600 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition-colors duration-200 font-medium">Subscribe</a>
                </div>

                <button id="theme-toggle" type="button" aria-label="Toogle Theme" class="p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-all duration-600 ml-2">
                    {{-- Light (sun) icon --}}
                    <svg id="theme-toggle-light-icon" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 hidden text-yellow-500" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zM4.22 4.22a1 1 0 011.415 0l.707.707a1 1 0 11-1.414 1.415l-.707-.707a1 1 0 010-1.415zM2 10a1 1 0 011-1h1a1 1 0 110 2H3a1 1 0 01-1-1zm8 5a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zm5.778-8.778a1 1 0 010 1.415l-.707.707a1 1 0 11-1.415-1.414l.707-.708a1 1 0 011.415 0zM16 9a1 1 0 011 1v0a1 1 0 11-2 0 1 1 0 011-1zM4.22 15.778a1 1 0 010-1.415l.707-.707a1 1 0 011.415 1.414l-.707.708a1 1 0 01-1.415 0zM15.778 15.778a1 1 0 00-1.415 0l-.707.707a1 1 0 101.414 1.414l.708-.707a1 1 0 000-1.414zM10 6a4 4 0 100 8 4 4 0 000-8z" />
                    </svg>
                    {{-- Dark (moon) icon --}}
                    <svg id="theme-toggle-dark-icon" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 hidden text-gray-200" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path d="M17.293 13.293A8 8 0 116.707 2.707a7 7 0 1010.586 10.586z" />
                    </svg>
                </button>
                {{-- Mobile menu button --}}
                <button id="mobile-menu-toggle" type="button" aria-label="Toggle Menu" class="md:hidden p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-all duration-200 ml-2">
                    <svg class="w-6 h-6 text-gray-700 dark:text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
            {{-- Mobile menu --}}
            <div id="mobile-menu" class="md:hidden hidden bg-white dark:bg-gray-900 border-t border-gray-200 dark:border-gray-700 py-4">
                <nav class="flex flex-col space-y-4">
                    <a href="{{ route('posts.index') }}" class="text-gray-700 dark:text-gray-200 hover:text-blue-600 dark:hover:text-blue-400 transition-colors duration-200 font-medium px-4">All Posts</a>
                    <a href="{{ route('posts.index', ['category' => 'politics']) }}" class="text-gray-700 dark:text-gray-200 hover:text-blue-600 dark:hover:text-blue-400 transition-colors duration-200 font-medium px-4">Politics</a>
                    <a href="{{ route('posts.index', ['category' => 'tech']) }}" class="text-gray-700 dark:text-gray-200 hover:text-blue-600 dark:hover:text-blue-400 transition-colors duration-200 font-medium px-4">Tech</a>
                    <a href="{{ route('posts.index', ['category' => 'culture']) }}" class="text-gray-700 dark:text-gray-200 hover:text-blue-600 dark:hover:text-blue-400 transition-colors duration-200 font-medium px-4">Culture</a>
                    <a href="#" class="text-gray-600 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition-colors duration-200 font-medium px-4">Subscribe</a>
                </nav>
            </div>
        </div>
    </header>

    {{-- optional hero / slot area below header --}}
    <div class="bg-gray-50 dark:bg-gray-900">
        <div class="max-w-7xl mx-auto px-6 py-6">
            {{ $slot }}
        </div>
    </div>
</div>


<script>
    (
        function () {
            const html = document.documentElement;
            const btn = document.getElementById('theme-toggle');
            if (!btn) return;

            const lightIcon = document.getElementById('theme-toggle-light-icon');
            const darkIcon = document.getElementById('theme-toggle-dark-icon');

            function setIcons(isDark) {
                if(isDark){
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
        }
    )();
</script>

@livewireScripts
</body>
</html>