<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>502 - Bad Gateway</title>
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
            <div class="mb-8">
                <svg class="w-32 h-32 mx-auto text-red-400 dark:text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                </svg>
            </div>
            
            <h1 class="text-6xl font-bold text-gray-900 dark:text-white mb-4">502</h1>
            <h2 class="text-2xl font-semibold text-gray-700 dark:text-gray-300 mb-4">Bad Gateway</h2>
            <p class="text-gray-600 dark:text-gray-400 mb-8">
                The server received an invalid response from the upstream server. This is usually a temporary issue.
            </p>

            {{-- Info Box --}}
            <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg p-6 mb-8">
                <div class="flex items-start gap-3">
                    <svg class="w-6 h-6 text-red-600 dark:text-red-400 shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                    </svg>
                    <div class="text-left flex-1">
                        <p class="text-sm font-medium text-red-800 dark:text-red-300 mb-2">
                            What's causing this?
                        </p>
                        <ul class="space-y-2 text-xs text-red-700 dark:text-red-400">
                            <li class="flex items-center gap-2">
                                <span class="w-1 h-1 bg-red-600 dark:bg-red-400 rounded-full"></span>
                                The web server (Nginx/Apache) can't reach the application server
                            </li>
                            <li class="flex items-center gap-2">
                                <span class="w-1 h-1 bg-red-600 dark:bg-red-400 rounded-full"></span>
                                Application server is overloaded or crashed
                            </li>
                            <li class="flex items-center gap-2">
                                <span class="w-1 h-1 bg-red-600 dark:bg-red-400 rounded-full"></span>
                                Server configuration or network issues
                            </li>
                            <li class="flex items-center gap-2">
                                <span class="w-1 h-1 bg-red-600 dark:bg-red-400 rounded-full"></span>
                                Temporary server restart or deployment
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            {{-- Status Check --}}
            <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-6 mb-8">
                <div class="flex items-center justify-center gap-3 mb-3">
                    <div class="w-3 h-3 bg-blue-600 dark:bg-blue-400 rounded-full animate-pulse"></div>
                    <p class="text-sm font-medium text-blue-800 dark:text-blue-300">
                        Our team has been notified
                    </p>
                </div>
                <p class="text-xs text-blue-700 dark:text-blue-400">
                    We're working to restore the service. Usually resolves in a few minutes.
                </p>
            </div>

            {{-- Action Buttons --}}
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <button onclick="window.location.reload()" 
                        class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-lg shadow-md hover:shadow-lg transition-all duration-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                    </svg>
                    Retry
                </button>
                
                <a href="{{ route('home') }}" 
                   class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-white dark:bg-gray-800 hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 font-semibold rounded-lg shadow-md hover:shadow-lg border border-gray-300 dark:border-gray-600 transition-all duration-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    Go Home
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

        // Auto-retry after 5 seconds
        setTimeout(() => window.location.reload(), 5000);
    </script>
</body>
</html>