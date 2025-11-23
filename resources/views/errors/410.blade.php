<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>410 - Gone</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 dark:bg-gray-900 transition-colors duration-200">
    {{-- Theme Toggle Button --}}
    <div class="fixed top-4 right-4 z-50">
        <button id="theme-toggle" type="button" aria-label="Toggle dark mode"
            class="relative p-2 rounded-lg bg-white dark:bg-gray-800 hover:bg-gray-100 dark:hover:bg-gray-700 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 shadow-lg">
            
            <svg id="theme-toggle-dark-icon"
                class="w-6 h-6 text-gray-800 dark:text-gray-900 transition-all duration-300"
                style="transform: scale(1); position: relative; z-index: 10;" 
                fill="currentColor" viewBox="0 0 20 20">
                <path d="M17.293 13.293A8 8 0 116.707 2.707a7 7 0 1010.586 10.586z" />
            </svg>

            <svg id="theme-toggle-light-icon"
                class="w-6 h-6 text-yellow-500 transition-transform duration-300 absolute inset-0 m-auto"
                style="transform: rotate(90deg) scale(0);" 
                fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd"
                    d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z"
                    clip-rule="evenodd"></path>
            </svg>
        </button>
    </div>

    <div class="min-h-screen flex items-center justify-center px-4">
        <div class="text-center max-w-md">
            <div class="mb-4">
                <svg class="w-32 h-32 mx-auto text-purple-400 dark:text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                </svg>
            </div>
            
            <h1 class="text-6xl font-bold text-gray-900 dark:text-white mb-4">410</h1>
            <h2 class="text-2xl font-semibold text-gray-700 dark:text-gray-300 mb-2">Content Permanently Removed</h2>
            <p class="text-gray-600 dark:text-gray-400 mb-8">
                This content has been permanently deleted and is no longer available. Unlike a temporary removal, it won't be coming back.
            </p>

            {{-- Information Box --}}
            <div class="bg-purple-50 dark:bg-purple-900/20 border border-purple-200 dark:border-purple-800 rounded-lg p-6 mb-4">
                <div class="flex items-start gap-3">
                    <svg class="w-6 h-6 text-purple-600 dark:text-purple-400 shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                    </svg>
                    <div class="text-left flex-1">
                        <p class="text-sm font-medium text-purple-800 dark:text-purple-300 mb-2">
                            Why was this removed?
                        </p>
                        <p class="text-xs text-purple-700 dark:text-purple-400">
                            This content may have been deleted due to:
                        </p>
                        <ul class="mt-2 space-y-1 text-xs text-purple-700 dark:text-purple-400">
                            <li class="flex items-center gap-2">
                                <span class="w-1 h-1 bg-purple-600 dark:bg-purple-400 rounded-full"></span>
                                Policy violations
                            </li>
                            <li class="flex items-center gap-2">
                                <span class="w-1 h-1 bg-purple-600 dark:bg-purple-400 rounded-full"></span>
                                Author's request
                            </li>
                            <li class="flex items-center gap-2">
                                <span class="w-1 h-1 bg-purple-600 dark:bg-purple-400 rounded-full"></span>
                                Outdated or inaccurate information
                            </li>
                            <li class="flex items-center gap-2">
                                <span class="w-1 h-1 bg-purple-600 dark:bg-purple-400 rounded-full"></span>
                                Content consolidation
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            {{-- Suggestions --}}
            <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-6 mb-4 text-left">
                <h3 class="text-sm font-semibold text-blue-800 dark:text-blue-300 mb-2 flex items-center gap-2">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M11 3a1 1 0 100 2h2.586l-6.293 6.293a1 1 0 101.414 1.414L15 6.414V9a1 1 0 102 0V4a1 1 0 00-1-1h-5z"></path>
                        <path d="M5 5a2 2 0 00-2 2v8a2 2 0 002 2h8a2 2 0 002-2v-3a1 1 0 10-2 0v3H5V7h3a1 1 0 000-2H5z"></path>
                    </svg>
                    What can you do instead?
                </h3>
                <ul class="space-y-2 text-sm text-blue-700 dark:text-blue-400">
                    <li class="flex items-start gap-2">
                        <svg class="w-4 h-4 mt-0.5 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <span>Search for similar content on our site</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <svg class="w-4 h-4 mt-0.5 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <span>Browse our latest posts</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <svg class="w-4 h-4 mt-0.5 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <span>Check our archives for related topics</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <svg class="w-4 h-4 mt-0.5 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <span>Contact us if you need specific information</span>
                    </li>
                </ul>
            </div>

            {{-- Action Buttons --}}
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('public.posts.index') }}" 
                   class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-purple-600 hover:bg-purple-700 text-white font-semibold rounded-lg shadow-md hover:shadow-lg transition-all duration-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    Search Posts
                </a>
                
                <a href="{{ route('public.posts.index') }}" 
                   class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-white dark:bg-gray-800 hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 font-semibold rounded-lg shadow-md hover:shadow-lg border border-gray-300 dark:border-gray-600 transition-all duration-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                    </svg>
                    Browse All Posts
                </a>
            </div>

            <div class="mt-6">
                <a href="{{ route('home') }}" class="text-sm text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300">
                    Or return to homepage
                </a>
            </div>
        </div>
    </div>

    <script>
        function initTheme() {
            const html = document.documentElement;
            const stored = localStorage.getItem('theme');
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
            localStorage.setItem('theme', isDark ? 'dark' : 'light');
            updateThemeIcon(isDark);
        }

        document.addEventListener('DOMContentLoaded', function() {
            initTheme();
            document.getElementById('theme-toggle')?.addEventListener('click', toggleTheme);
        });

        initTheme();
    </script>
</body>
</html>