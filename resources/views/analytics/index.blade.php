<x-layouts.app :title="'Analytics'">
   
        <div class="container mx-auto px-4 py-8">
            <h1 class="text-3xl font-bold mb-8">Analytics Dashboard</h1>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                    <div class="text-gray-500 dark:text-gray-400 text-sm">Total Views (30d)</div>
                    <div class="text-3xl font-bold mt-2">{{ number_format($stats['total_views']) }}</div>
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                    <div class="text-gray-500 dark:text-gray-400 text-sm">Unique Visitors</div>
                    <div class="text-3xl font-bold mt-2">{{ number_format($stats['unique_visitors']) }}</div>
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                    <div class="text-gray-500 dark:text-gray-400 text-sm">Avg. Time on Site</div>
                    <div class="text-3xl font-bold mt-2">{{ $stats['avg_time_on_site'] }}m</div>
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                    <div class="text-gray-500 dark:text-gray-400 text-sm">Bounce Rate</div>
                    <div class="text-3xl font-bold mt-2">{{ $stats['bounce_rate'] }}%</div>
                </div>
            </div>

            <!-- Traffic Chart -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 mb-8">
                <h2 class="text-xl font-bold mb-4">Daily Traffic (Last 30 Days)</h2>
                <canvas id="trafficChart" height="80"></canvas>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Top Posts -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                    <h2 class="text-xl font-bold mb-4">Top 10 Posts</h2>
                    <div class="space-y-4">
                        @foreach($topPosts as $post)
                            <div class="flex justify-between items-center">
                                <div class="flex-1">
                                    <a href="{{ route('public.posts.show', $post->id) }}" class="text-blue-600 hover:underline">
                                        {{ Str::limit($post->title, 50) }}
                                    </a>
                                    <div class="text-sm text-gray-500">
                                        {{ $post->category->name }}
                                    </div>
                                </div>
                                <div class="ml-4 text-right">
                                    <div class="font-bold">{{ number_format($post->views_count) }}</div>
                                    <div class="text-xs text-gray-500">views</div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Device Breakdown -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                    <h2 class="text-xl font-bold mb-4">Traffic by Device</h2>
                    <canvas id="deviceChart"></canvas>
                </div>
            </div>
        </div>

        @push('scripts')
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <script>
                // Traffic Line Chart
                const trafficCtx = document.getElementById('trafficChart').getContext('2d');
                new Chart(trafficCtx, {
                    type: 'line',
                    data: {
                        labels: {!! json_encode($dailyTraffic->pluck('date')) !!},
                        datasets: [{
                            label: 'Page Views',
                            data: {!! json_encode($dailyTraffic->pluck('views')) !!},
                            borderColor: 'rgb(59, 130, 246)',
                            backgroundColor: 'rgba(59, 130, 246, 0.1)',
                            tension: 0.4
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: true,
                    }
                });

                // Device Pie Chart
                const deviceCtx = document.getElementById('deviceChart').getContext('2d');
                new Chart(deviceCtx, {
                    type: 'doughnut',
                    data: {
                        labels: {!! json_encode($deviceStats->keys()) !!},
                        datasets: [{
                            data: {!! json_encode($deviceStats->values()) !!},
                            backgroundColor: [
                                'rgb(59, 130, 246)',
                                'rgb(16, 185, 129)',
                                'rgb(245, 158, 11)'
                            ]
                        }]
                    }
                });
            </script>
        @endpush
    
</x-layouts.app>