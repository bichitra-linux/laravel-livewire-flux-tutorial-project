<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>504 - Gateway Timeout</title>
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
                <svg class="w-32 h-32 mx-auto text-purple-400 dark:text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            
            <h1 class="text-6xl font-bold text-gray-900 dark:text-white mb-4">504</h1>
            <h2 class="text-2xl font-semibold text-gray-700 dark:text-gray-300 mb-4">Gateway Timeout</h2>
            <p class="text-gray-600 dark:text-gray-400 mb-8">
                The server didn't get a timely response from the upstream server. The request took too long to process.
            </p>

            {{-- Info Box --}}
            <div class="bg-purple-50 dark:bg-purple-900/20 border border-purple-200 dark:border-purple-800 rounded-lg p-6 mb-8">
                <div class="flex items-start gap-3">
                    <svg class="w-6 h-6 text-purple-600 dark:text-purple-400 shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                    </svg>
                    <div class="text-left flex-1">
                        <p class="text-sm font-medium text-purple-800 dark:text-purple-300 mb-2">
                            Why is this happening?
                        </p>
                        <ul class="space-y-2 text-xs text-purple-700 dark:text-purple-400">
                            <li class="flex items-center gap-2">
                                <span class="w-1 h-1 bg-purple-600 dark:bg-purple-400 rounded-full"></span>
                                Database queries taking too long
                            </li>
                            <li class="flex items-center gap-2">
                                <span class="w-1 h-1 bg-purple-600 dark:bg-purple-400 rounded-full"></span>
                                External API calls timing out
                            </li>
                            <li class="flex items-center gap-2">
                                <span class="w-1 h-1 bg-purple-600 dark:bg-purple-400 rounded-full"></span>
                                Server under heavy load
                            </li>
                            <li class="flex items-center gap-2">
                                <span class="w-1 h-1 bg-purple-600 dark:bg-purple-400 rounded-full"></span>
                                Network connectivity issues
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            {{-- Progress Indicator --}}
            <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-6 mb-8">
                <div class="flex items-center justify-center gap-3 mb-4">
                    <svg class="w-6 h-6 text-blue-600 dark:text-blue-400 animate-spin" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <p class="text-sm font-medium text-blue-800 dark:text-blue-300">
                        Processing your request...
                    </p>
                </div>
                <p class="text-xs text-blue-700 dark:text-blue-400">
                    This might take a moment. We're working on it!
                </p>
            </div>

            {{-- Action Buttons --}}
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <button onclick="window.location.reload()" 
                        class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-purple-600 hover:bg-purple-700 text-white font-semibold rounded-lg shadow-md hover:shadow-lg transition-all duration-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                    </svg>
                    Try Again
                </button>
                
                <a href="{{ route('home') }}" 
                   class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-white dark:bg-gray-800 hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 font-semibold rounded-lg shadow-md hover:shadow-lg border border-gray-300 dark:border-gray-600 transition-all duration-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    Go Home
                </a>
            </div>

            {{-- Help Text --}}
            <div class="mt-6">
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    Still having issues? 
                    <a href="#" class="text-blue-600 dark:text-blue-400 hover:underline font-medium">
                        Contact support
                    </a>
                </p>
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