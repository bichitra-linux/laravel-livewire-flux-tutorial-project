<x-layouts.app.sidebar :title="'Analytics'">
    <flux:main container class="space-y-6">
        {{-- Header Section --}}
        <div class="bg-white dark:bg-zinc-800 rounded-xl p-6 shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-zinc-900 dark:text-white">📊 Analytics Dashboard</h1>
                    <p class="text-zinc-600 dark:text-zinc-400 mt-2">Comprehensive insights into your blog's performance
                    </p>
                </div>
                <div class="hidden md:block">
                    <div class="flex items-center gap-2 text-sm text-zinc-600 dark:text-zinc-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                            </path>
                        </svg>
                        <span>Last 30 Days</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Main Stats Grid --}}
        <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-4">
            {{-- Total Views --}}
            <div
                class="bg-white dark:bg-zinc-800 rounded-xl p-6 shadow-lg hover:shadow-xl transition-shadow duration-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-zinc-600 dark:text-zinc-400">Total Views</p>
                        <p class="text-3xl font-bold text-zinc-900 dark:text-white mt-2">
                            {{ number_format($stats['total_views']) }}</p>
                        <p class="text-xs text-zinc-500 dark:text-zinc-400 mt-1">Last 30 days</p>
                    </div>
                    <div class="p-3 rounded-full bg-blue-100 dark:bg-blue-900/30">
                        <svg class="w-8 h-8 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                            </path>
                        </svg>
                    </div>
                </div>
            </div>

            {{-- Unique Visitors --}}
            <div
                class="bg-white dark:bg-zinc-800 rounded-xl p-6 shadow-lg hover:shadow-xl transition-shadow duration-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-zinc-600 dark:text-zinc-400">Unique Visitors</p>
                        <p class="text-3xl font-bold text-zinc-900 dark:text-white mt-2">
                            {{ number_format($stats['unique_visitors']) }}</p>
                        <p class="text-xs text-green-600 dark:text-green-400 mt-1">
                            {{ $stats['total_views'] > 0 ? round(($stats['unique_visitors'] / $stats['total_views']) * 100) : 0 }}%
                            conversion
                        </p>
                    </div>
                    <div class="p-3 rounded-full bg-green-100 dark:bg-green-900/30">
                        <svg class="w-8 h-8 text-green-600 dark:text-green-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                            </path>
                        </svg>
                    </div>
                </div>
            </div>

            {{-- Avg Time on Site --}}
            <div
                class="bg-white dark:bg-zinc-800 rounded-xl p-6 shadow-lg hover:shadow-xl transition-shadow duration-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-zinc-600 dark:text-zinc-400">Avg. Time on Site</p>
                        <p class="text-3xl font-bold text-zinc-900 dark:text-white mt-2">
                            {{ $stats['avg_time_on_site'] }}<span class="text-lg">m</span></p>
                        <p class="text-xs text-purple-600 dark:text-purple-400 mt-1">Per session</p>
                    </div>
                    <div class="p-3 rounded-full bg-purple-100 dark:bg-purple-900/30">
                        <svg class="w-8 h-8 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            {{-- Bounce Rate --}}
            <div
                class="bg-white dark:bg-zinc-800 rounded-xl p-6 shadow-lg hover:shadow-xl transition-shadow duration-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-zinc-600 dark:text-zinc-400">Bounce Rate</p>
                        <p class="text-3xl font-bold text-zinc-900 dark:text-white mt-2">
                            {{ $stats['bounce_rate'] }}<span class="text-lg">%</span></p>
                        <p class="text-xs text-orange-600 dark:text-orange-400 mt-1">Single page visits</p>
                    </div>
                    <div class="p-3 rounded-full bg-orange-100 dark:bg-orange-900/30">
                        <svg class="w-8 h-8 text-orange-600 dark:text-orange-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        {{-- Secondary Stats --}}
        <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-4">
            {{-- Pages per Session --}}
            <div class="bg-white dark:bg-zinc-800 rounded-xl p-4 shadow-lg">
                <div class="flex items-center gap-3">
                    <div class="p-2 rounded-lg bg-indigo-100 dark:bg-indigo-900/30">
                        <svg class="w-6 h-6 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                            </path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs text-zinc-600 dark:text-zinc-400">Pages/Session</p>
                        <p class="text-xl font-bold text-zinc-900 dark:text-white">
                            {{ $stats['unique_visitors'] > 0 ? number_format($stats['total_views'] / $stats['unique_visitors'], 1) : 0 }}
                        </p>
                    </div>
                </div>
            </div>

            {{-- New Visitors --}}
            <div class="bg-white dark:bg-zinc-800 rounded-xl p-4 shadow-lg">
                <div class="flex items-center gap-3">
                    <div class="p-2 rounded-lg bg-teal-100 dark:bg-teal-900/30">
                        <svg class="w-6 h-6 text-teal-600 dark:text-teal-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z">
                            </path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs text-zinc-600 dark:text-zinc-400">New Visitors</p>
                        <p class="text-xl font-bold text-zinc-900 dark:text-white">
                            {{ number_format($stats['new_visitors']) }}</p>
                    </div>
                </div>
            </div>

            {{-- Return Rate --}}
            <div class="bg-white dark:bg-zinc-800 rounded-xl p-4 shadow-lg">
                <div class="flex items-center gap-3">
                    <div class="p-2 rounded-lg bg-pink-100 dark:bg-pink-900/30">
                        <svg class="w-6 h-6 text-pink-600 dark:text-pink-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
                            </path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs text-zinc-600 dark:text-zinc-400">Return Rate</p>
                        <p class="text-xl font-bold text-zinc-900 dark:text-white">{{ $stats['return_rate'] }}%</p>
                    </div>
                </div>
            </div>

            {{-- Engagement Rate --}}
            <div class="bg-white dark:bg-zinc-800 rounded-xl p-4 shadow-lg">
                <div class="flex items-center gap-3">
                    <div class="p-2 rounded-lg bg-yellow-100 dark:bg-yellow-900/30">
                        <svg class="w-6 h-6 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z">
                            </path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs text-zinc-600 dark:text-zinc-400">Engagement</p>
                        <p class="text-xl font-bold text-zinc-900 dark:text-white">{{ $stats['engagement_rate'] }}%</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Traffic Chart --}}
        <div class="bg-white dark:bg-zinc-800 rounded-xl p-6 shadow-lg">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-bold text-zinc-900 dark:text-white flex items-center gap-2">
                    <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                        </path>
                    </svg>
                    Daily Traffic Trends
                </h2>
                <div class="flex items-center gap-2">
                    <span class="w-3 h-3 rounded-full bg-blue-600"></span>
                    <span class="text-sm text-zinc-600 dark:text-zinc-400">Page Views</span>
                </div>
            </div>
            <canvas id="trafficChart" height="80"></canvas>
        </div>

        {{-- Main Content Grid --}}
        <div class="grid gap-6 lg:grid-cols-3">
            {{-- Top Posts --}}
            <div class="lg:col-span-2 bg-white dark:bg-zinc-800 rounded-xl p-6 shadow-lg">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-xl font-bold text-zinc-900 dark:text-white flex items-center gap-2">
                        <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z">
                            </path>
                        </svg>
                        Top Performing Posts
                    </h2>
                    <span
                        class="text-xs text-zinc-500 dark:text-zinc-400 bg-zinc-100 dark:bg-zinc-700 px-3 py-1 rounded-full">Last
                        30 Days</span>
                </div>

                @if($topPosts->count() > 0)
                    <div class="space-y-3">
                        @foreach($topPosts as $index => $post)
                            <div
                                class="flex items-start gap-4 p-4 rounded-lg hover:bg-zinc-50 dark:hover:bg-zinc-700/50 transition-colors group">
                                {{-- Rank Badge --}}
                                <div class="shrink-0">
                                    <div
                                        class="w-10 h-10 rounded-lg {{ $index === 0 ? 'bg-linear-to-br from-yellow-400 to-orange-500' : ($index === 1 ? 'bg-linear-to-br from-gray-300 to-gray-400' : ($index === 2 ? 'bg-linear-to-br from-orange-400 to-yellow-600' : 'bg-zinc-200 dark:bg-zinc-700')) }} flex items-center justify-center font-bold text-white shadow-lg">
                                        {{ $index + 1 }}
                                    </div>
                                </div>

                                {{-- Post Info --}}
                                <div class="flex-1 min-w-0">
                                    <p class="text-zinc-900 dark:text-white font-semibold line-clamp-1">
                                        {{ $post->title }}
                                    </p>
                                    <div class="flex items-center gap-3 mt-2 text-xs text-zinc-500 dark:text-zinc-400">
                                        <span class="flex items-center gap-1 bg-blue-50 dark:bg-blue-900/20 px-2 py-1 rounded">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z">
                                                </path>
                                            </svg>
                                            {{ $post->category?->name ?? 'Uncategorized' }}
                                        </span>
                                        <span class="flex items-center gap-1">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                                </path>
                                            </svg>
                                            {{ $post->created_at->format('M d, Y') }}
                                        </span>
                                    </div>
                                </div>

                                {{-- Stats --}}
                                <div class="shrink-0 text-right">
                                    <div class="flex items-center gap-2">
                                        <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                            </path>
                                        </svg>
                                        <span
                                            class="text-2xl font-bold text-zinc-900 dark:text-white">{{ number_format($post->view_total) }}</span>
                                    </div>
                                    <p class="text-xs text-zinc-500 dark:text-zinc-400 mt-1">views</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-12">
                        <svg class="mx-auto h-12 w-12 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                            </path>
                        </svg>
                        <p class="mt-4 text-zinc-600 dark:text-zinc-400">No analytics data available yet.</p>
                    </div>
                @endif
            </div>

            {{-- Sidebar Stats --}}
            <div class="space-y-6">
                {{-- Device Breakdown --}}
                <div class="bg-white dark:bg-zinc-800 rounded-xl p-6 shadow-lg">
                    <h2 class="text-lg font-bold text-zinc-900 dark:text-white mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                        </svg>
                        Device Breakdown
                    </h2>

                    @if($deviceStats->isNotEmpty())
                        <canvas id="deviceChart" class="mb-4 mt-2"></canvas>

                        <div class="space-y-3 mt-6">
                            @foreach($deviceStats as $device => $count)
                                @php
                                    $percentage = $stats['total_views'] > 0 ? ($count / $stats['total_views'] * 100) : 0;
                                    $deviceColors = [
                                        'mobile' => ['bg' => 'bg-blue-100 dark:bg-blue-900/30', 'text' => 'text-blue-600 dark:text-blue-400', 'bar' => 'bg-blue-600'],
                                        'desktop' => ['bg' => 'bg-green-100 dark:bg-green-900/30', 'text' => 'text-green-600 dark:text-green-400', 'bar' => 'bg-green-600'],
                                        'tablet' => ['bg' => 'bg-orange-100 dark:bg-orange-900/30', 'text' => 'text-orange-600 dark:text-orange-400', 'bar' => 'bg-orange-600'],
                                    ];
                                    $colors = $deviceColors[strtolower($device)] ?? ['bg' => 'bg-zinc-100', 'text' => 'text-zinc-600', 'bar' => 'bg-zinc-600'];
                                @endphp

                                <div class="flex items-center justify-between p-6 rounded-lg {{ $colors['bg'] }}">
                                    <span class="text-sm font-medium {{ $colors['text'] }} capitalize">{{ $device }}</span>
                                    <div class="flex items-center gap-2">
                                        <span
                                            class="text-sm font-bold {{ $colors['text'] }}">{{ number_format($percentage, 1) }}%</span>
                                        <span
                                            class="text-xs text-zinc-500 dark:text-zinc-400">({{ number_format($count) }})</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-center py-8 text-zinc-500">No device data available</p>
                    @endif
                </div>

                {{-- Browser Stats --}}
                @if(isset($browserStats) && $browserStats->isNotEmpty())
                    <div class="bg-white dark:bg-zinc-800 rounded-xl p-6 shadow-lg">
                        <h2 class="text-lg font-bold text-zinc-900 dark:text-white mb-4 flex items-center gap-2">
                            <svg class="w-5 h-5 text-teal-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9">
                                </path>
                            </svg>
                            Top Browsers
                        </h2>

                        <div class="space-y-2">
                            @foreach($browserStats as $browser => $count)
                                @php
                                    $percentage = $stats['total_views'] > 0 ? ($count / $stats['total_views'] * 100) : 0;
                                @endphp
                                <div>
                                    <div class="flex items-center justify-between mb-1">
                                        <span
                                            class="text-sm font-medium text-zinc-900 dark:text-white capitalize">{{ $browser }}</span>
                                        <span
                                            class="text-xs text-zinc-500 dark:text-zinc-400">{{ number_format($percentage, 1) }}%</span>
                                    </div>
                                    <div class="w-full h-2 bg-zinc-200 dark:bg-zinc-700 rounded-full overflow-hidden">
                                        <div class="h-full bg-linear-to-r from-teal-500 to-teal-600 rounded-full"
                                            style="width: {{ $percentage }}%"></div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- Quick Stats --}}
                <div class="bg-linear-to-br from-blue-600 to-purple-600 rounded-xl p-6 shadow-lg text-white">
                    <h2 class="text-lg font-bold mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                        Quick Insights
                    </h2>

                    <div class="space-y-3">
                        <div class="bg-white/10 backdrop-blur-sm rounded-lg p-3">
                            <div class="text-white/80 text-xs mb-1">Peak Traffic Day</div>
                            <div class="font-bold">{{ $peakDay ?? 'N/A' }}</div>
                        </div>

                        <div class="bg-white/10 backdrop-blur-sm rounded-lg p-3">
                            <div class="text-white/80 text-xs mb-1">Most Active Hour</div>
                            <div class="font-bold">{{ $peakHour ?? 'N/A' }}</div>
                        </div>

                        <div class="bg-white/10 backdrop-blur-sm rounded-lg p-3">
                            <div class="text-white/80 text-xs mb-1">Growth This Week</div>
                            <div class="font-bold flex items-center gap-1">
                                @if(($weeklyGrowth ?? 0) >= 0)
                                    <svg class="w-4 h-4 text-green-300" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                    </svg>
                                    <span class="text-green-300">+{{ number_format($weeklyGrowth ?? 0, 1) }}%</span>
                                @else
                                    <svg class="w-4 h-4 text-red-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"></path>
                                    </svg>
                                    <span class="text-red-300">{{ number_format($weeklyGrowth ?? 0, 1) }}%</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </flux:main>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            //   Detect current theme
            const isDarkMode = () => document.documentElement.classList.contains('dark');

            //   Theme-aware color function
            const getThemeColors = () => {
                const dark = isDarkMode();
                return {
                    // Line chart colors
                    lineColor: dark ? 'rgb(96, 165, 250)' : 'rgb(59, 130, 246)',
                    lineGradientStart: dark ? 'rgba(96, 165, 250, 0.3)' : 'rgba(59, 130, 246, 0.2)',
                    lineGradientEnd: dark ? 'rgba(96, 165, 250, 0)' : 'rgba(59, 130, 246, 0)',

                    // Grid colors
                    gridColor: dark ? 'rgba(255, 255, 255, 0.1)' : 'rgba(0, 0, 0, 0.05)',

                    // Text colors
                    textColor: dark ? 'rgb(161, 161, 170)' : 'rgb(82, 82, 91)',
                    labelColor: dark ? 'rgb(228, 228, 231)' : 'rgb(24, 24, 27)',

                    // Tooltip colors
                    tooltipBg: dark ? 'rgba(24, 24, 27, 0.95)' : 'rgba(0, 0, 0, 0.8)',
                    tooltipBorder: dark ? 'rgb(63, 63, 70)' : 'rgb(228, 228, 231)',

                    // Doughnut colors (vibrant for both themes)
                    doughnutColors: [
                        dark ? 'rgb(96, 165, 250)' : 'rgb(59, 130, 246)',   // Blue
                        dark ? 'rgb(52, 211, 153)' : 'rgb(16, 185, 129)',   // Green
                        dark ? 'rgb(251, 146, 60)' : 'rgb(245, 158, 11)'    // Orange
                    ]
                };
            };

            let trafficChart = null;
            let deviceChart = null;

            //   Create/Update Traffic Chart
            function createTrafficChart() {
                const colors = getThemeColors();
                const ctx = document.getElementById('trafficChart').getContext('2d');

                // Create gradient
                const gradient = ctx.createLinearGradient(0, 0, 0, 400);
                gradient.addColorStop(0, colors.lineGradientStart);
                gradient.addColorStop(1, colors.lineGradientEnd);

                const config = {
                    type: 'line',
                    data: {
                        labels: {!! json_encode($dailyTraffic->pluck('traffic_date')->map(fn($d) => \Carbon\Carbon::parse($d)->format('M d'))) !!},
                        datasets: [{
                            label: 'Page Views',
                            data: {!! json_encode($dailyTraffic->pluck('daily_views')) !!},
                            borderColor: colors.lineColor,
                            backgroundColor: gradient,
                            borderWidth: 3,
                            fill: true,
                            tension: 0.4,
                            pointBackgroundColor: colors.lineColor,
                            pointBorderColor: '#fff',
                            pointBorderWidth: 2,
                            pointRadius: 3,
                            pointHoverRadius: 5,
                            pointHoverBackgroundColor: colors.lineColor,
                            pointHoverBorderColor: '#fff',
                            pointHoverBorderWidth: 3
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: true,
                        interaction: {
                            mode: 'index',
                            intersect: false,
                        },
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                backgroundColor: colors.tooltipBg,
                                titleColor: '#fff',
                                bodyColor: '#fff',
                                borderColor: colors.tooltipBorder,
                                borderWidth: 1,
                                padding: 12,
                                titleFont: { size: 14, weight: 'bold' },
                                bodyFont: { size: 13 },
                                cornerRadius: 8,
                                displayColors: false
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                border: {
                                    display: false
                                },
                                grid: {
                                    color: colors.gridColor,
                                    drawBorder: false
                                },
                                ticks: {
                                    color: colors.textColor,
                                    font: { size: 11 },
                                    padding: 8
                                }
                            },
                            x: {
                                border: {
                                    display: false
                                },
                                grid: {
                                    display: false
                                },
                                ticks: {
                                    color: colors.textColor,
                                    font: { size: 11 },
                                    padding: 8
                                }
                            }
                        }
                    }
                };

                if (trafficChart) {
                    trafficChart.destroy();
                }
                trafficChart = new Chart(ctx, config);
            }

            @if($deviceStats->isNotEmpty())
                //   Create/Update Device Chart
                function createDeviceChart() {
                    const colors = getThemeColors();
                    const ctx = document.getElementById('deviceChart').getContext('2d');

                    const config = {
                        type: 'doughnut',
                        data: {
                            labels: {!! json_encode($deviceStats->keys()->map(fn($k) => ucfirst($k))) !!},
                            datasets: [{
                                data: {!! json_encode($deviceStats->values()) !!},
                                backgroundColor: colors.doughnutColors,
                                borderWidth: 0,
                                hoverOffset: 6,
                                hoverBorderWidth: 0
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: true,
                            plugins: {
                                legend: {
                                    position: 'bottom',
                                    labels: {
                                        padding: 12,
                                        font: { size: 12, weight: '500' },
                                        usePointStyle: true,
                                        pointStyle: 'circle',
                                        color: colors.labelColor
                                    }
                                },
                                tooltip: {
                                    backgroundColor: colors.tooltipBg,
                                    titleColor: '#fff',
                                    bodyColor: '#fff',
                                    borderColor: colors.tooltipBorder,
                                    borderWidth: 1,
                                    padding: 12,
                                    cornerRadius: 8,
                                    callbacks: {
                                        label: function (context) {
                                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                            const percentage = ((context.parsed / total) * 100).toFixed(1);
                                            return ` ${context.label}: ${context.parsed.toLocaleString()} (${percentage}%)`;
                                        }
                                    }
                                }
                            },
                            cutout: '65%'
                        }
                    };

                    if (deviceChart) {
                        deviceChart.destroy();
                    }
                    deviceChart = new Chart(ctx, config);
                }
            @endif

            //   Initialize charts
            function initCharts() {
                createTrafficChart();
                @if($deviceStats->isNotEmpty())
                    createDeviceChart();
                @endif
                }

            //   Initialize on page load
            document.addEventListener('DOMContentLoaded', initCharts);

            //   Watch for theme changes
            const observer = new MutationObserver((mutations) => {
                mutations.forEach((mutation) => {
                    if (mutation.attributeName === 'class') {
                        // Theme changed, recreate charts with new colors
                        initCharts();
                    }
                });
            });

            observer.observe(document.documentElement, {
                attributes: true,
                attributeFilter: ['class']
            });

            //   Cleanup on page unload
            window.addEventListener('beforeunload', () => {
                if (trafficChart) trafficChart.destroy();
                if (deviceChart) deviceChart.destroy();
                observer.disconnect();
            });
        </script>
    @endpush
</x-layouts.app.sidebar>