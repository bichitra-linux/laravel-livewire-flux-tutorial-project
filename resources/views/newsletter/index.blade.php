<x-layouts.app :title="'Newsletter'">
    <div class="flex h-full w-full flex-1 flex-col gap-6 rounded-xl p-6">
        {{-- Header Section --}}
        <div class="bg-white dark:bg-zinc-800 rounded-xl p-6 shadow-lg dark:text-white">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold flex items-center gap-3">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        Newsletter Subscribers
                    </h1>
                    <p class="text-purple-100 mt-2">Manage your newsletter subscribers and export data.</p>
                </div>
                <div class="hidden md:block">
                    <a href="{{ route('newsletter.export') }}" 
                        class="flex items-center gap-2 bg-white/20 hover:bg-white/30 backdrop-blur-sm text-white px-6 py-3 rounded-lg font-semibold transition-all duration-200 shadow-lg hover:shadow-xl border border-white/30">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Export CSV
                    </a>
                </div>
            </div>
        </div>

        {{-- Stats Cards --}}
        <div class="grid gap-4 md:grid-cols-4">
            {{-- Total Subscribers --}}
            <div class="bg-white dark:bg-zinc-800 rounded-xl p-6 shadow-lg hover:shadow-xl transition-shadow duration-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Subscribers</p>
                        <p class="text-3xl font-bold text-gray-900 dark:text-white mt-2">{{ number_format($stats['total']) }}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">All time</p>
                    </div>
                    <div class="p-3 rounded-full bg-blue-100 dark:bg-blue-900/30">
                        <svg class="w-8 h-8 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            {{-- Active Subscribers --}}
            <div class="bg-white dark:bg-zinc-800 rounded-xl p-6 shadow-lg hover:shadow-xl transition-shadow duration-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Active</p>
                        <p class="text-3xl font-bold text-gray-900 dark:text-white mt-2">{{ number_format($stats['active']) }}</p>
                        <p class="text-xs text-green-600 dark:text-green-400 mt-1">
                            {{ $stats['total'] > 0 ? round(($stats['active'] / $stats['total']) * 100, 1) : 0 }}% subscribed
                        </p>
                    </div>
                    <div class="p-3 rounded-full bg-green-100 dark:bg-green-900/30">
                        <svg class="w-8 h-8 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            {{-- Unsubscribed --}}
            <div class="bg-white dark:bg-zinc-800 rounded-xl p-6 shadow-lg hover:shadow-xl transition-shadow duration-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Unsubscribed</p>
                        <p class="text-3xl font-bold text-gray-900 dark:text-white mt-2">{{ number_format($stats['unsubscribed']) }}</p>
                        <p class="text-xs text-red-600 dark:text-red-400 mt-1">Opted out</p>
                    </div>
                    <div class="p-3 rounded-full bg-red-100 dark:bg-red-900/30">
                        <svg class="w-8 h-8 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path>
                        </svg>
                    </div>
                </div>
            </div>

            {{-- New Today --}}
            <div class="bg-white dark:bg-zinc-800 rounded-xl p-6 shadow-lg hover:shadow-xl transition-shadow duration-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">New Today</p>
                        <p class="text-3xl font-bold text-gray-900 dark:text-white mt-2">{{ number_format($stats['today']) }}</p>
                        <p class="text-xs text-purple-600 dark:text-purple-400 mt-1">Last 24 hours</p>
                    </div>
                    <div class="p-3 rounded-full bg-purple-100 dark:bg-purple-900/30">
                        <svg class="w-8 h-8 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        {{-- Subscribers Table --}}
        <div class="bg-white dark:bg-zinc-800 rounded-xl shadow-lg overflow-hidden">
            <div class="p-6">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-900">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    Email
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    Name
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    Status
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    Subscribed At
                                </th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-zinc-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse($subscribers as $subscriber)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center gap-3">
                                            <div class="shrink-0 h-10 w-10 rounded-full bg-linear-to-br from-purple-500 to-pink-500 flex items-center justify-center text-white font-semibold">
                                                {{ strtoupper(substr($subscriber->email, 0, 2)) }}
                                            </div>
                                            <div>
                                                <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $subscriber->email }}</div>
                                                <div class="text-xs text-gray-500 dark:text-gray-400">
                                                    IP: {{ $subscriber->ip_address ?? 'N/A' }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900 dark:text-white">
                                            {{ $subscriber->name ?? 'N/A' }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($subscriber->is_subscribed)
                                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">
                                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                                </svg>
                                                Active
                                            </span>
                                        @else
                                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400">
                                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                                </svg>
                                                Unsubscribed
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                        <div>{{ $subscriber->subscribed_at?->format('M d, Y') ?? 'N/A' }}</div>
                                        <div class="text-xs text-gray-400">{{ $subscriber->subscribed_at?->format('H:i') ?? '' }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <button 
                                            onclick="showDetails({{ json_encode($subscriber) }})"
                                            class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300 transition-colors" 
                                            title="View Details">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-12 text-center text-gray-500 dark:text-gray-400">
                                        <svg class="mx-auto h-12 w-12 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                                        </svg>
                                        <p class="text-lg font-medium">No subscribers yet</p>
                                        <p class="text-sm mt-1">Start building your audience!</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                @if($subscribers->hasPages())
                    <div class="mt-6">
                        {{ $subscribers->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Details Modal --}}
    <div id="detailsModal" class="hidden fixed inset-0 bg-zinc-900/60 backdrop-blur-sm transition-opacity overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-full max-w-lg shadow-2xl rounded-xl bg-white dark:bg-gray-800">
            <div class="mt-3">
                {{-- Modal Header --}}
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white flex items-center gap-2">
                        <svg class="w-6 h-6 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        Subscriber Details
                    </h3>
                    <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                {{-- Modal Content --}}
                <div id="modalContent" class="space-y-4">
                    <!-- Content will be injected by JavaScript -->
                </div>

                {{-- Modal Footer --}}
                <div class="mt-6 flex gap-2">
                    <button 
                        onclick="closeModal()"
                        class="flex-1 px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-600 transition-colors font-medium">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function showDetails(subscriber) {
            const modal = document.getElementById('detailsModal');
            const content = document.getElementById('modalContent');
            
            content.innerHTML = `
                <div class="bg-gradient-to-r from-purple-50 to-pink-50 dark:from-purple-900/20 dark:to-pink-900/20 rounded-lg p-4 mb-4">
                    <div class="flex items-center gap-3">
                        <div class="flex-shrink-0 h-12 w-12 rounded-full bg-gradient-to-br from-purple-500 to-pink-500 flex items-center justify-center text-white font-bold text-lg">
                            ${subscriber.email.substring(0, 2).toUpperCase()}
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900 dark:text-white truncate">${subscriber.email}</p>
                            <p class="text-xs text-gray-600 dark:text-gray-400">${subscriber.name || 'No name provided'}</p>
                        </div>
                        ${subscriber.is_subscribed 
                            ? '<span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">Active</span>'
                            : '<span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400">Unsubscribed</span>'
                        }
                    </div>
                </div>

                <div class="space-y-3">
                    <div class="bg-gray-50 dark:bg-gray-700/50 rounded-lg p-3">
                        <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">Email Address</p>
                        <p class="text-sm text-gray-900 dark:text-white font-medium break-all">${subscriber.email}</p>
                    </div>

                    <div class="bg-gray-50 dark:bg-gray-700/50 rounded-lg p-3">
                        <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">Name</p>
                        <p class="text-sm text-gray-900 dark:text-white">${subscriber.name || 'Not provided'}</p>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div class="bg-gray-50 dark:bg-gray-700/50 rounded-lg p-3">
                            <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">Status</p>
                            <p class="text-sm font-semibold ${subscriber.is_subscribed ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400'}">
                                ${subscriber.is_subscribed ? '✅ Active' : '❌ Unsubscribed'}
                            </p>
                        </div>

                        <div class="bg-gray-50 dark:bg-gray-700/50 rounded-lg p-3">
                            <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">IP Address</p>
                            <p class="text-sm text-gray-900 dark:text-white font-mono">${subscriber.ip_address || 'N/A'}</p>
                        </div>
                    </div>

                    <div class="bg-gray-50 dark:bg-gray-700/50 rounded-lg p-3">
                        <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">User Agent</p>
                        <p class="text-xs text-gray-700 dark:text-gray-300 break-all leading-relaxed">${subscriber.user_agent || 'Not available'}</p>
                    </div>

                    <div class="bg-gray-50 dark:bg-gray-700/50 rounded-lg p-3">
                        <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">Subscribed At</p>
                        <p class="text-sm text-gray-900 dark:text-white">${subscriber.subscribed_at ? new Date(subscriber.subscribed_at).toLocaleString('en-US', { 
                            dateStyle: 'full', 
                            timeStyle: 'short' 
                        }) : 'N/A'}</p>
                    </div>

                    ${subscriber.unsubscribed_at ? `
                    <div class="bg-red-50 dark:bg-red-900/20 rounded-lg p-3 border border-red-200 dark:border-red-800">
                        <p class="text-xs font-medium text-red-600 dark:text-red-400 uppercase tracking-wider mb-1">Unsubscribed At</p>
                        <p class="text-sm text-red-900 dark:text-red-300">${new Date(subscriber.unsubscribed_at).toLocaleString('en-US', { 
                            dateStyle: 'full', 
                            timeStyle: 'short' 
                        })}</p>
                    </div>
                    ` : ''}
                </div>
            `;
            
            modal.classList.remove('hidden');
        }
        
        function closeModal() {
            document.getElementById('detailsModal').classList.add('hidden');
        }
        
        // Close modal on outside click
        document.getElementById('detailsModal')?.addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal();
            }
        });

        // Close modal on Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeModal();
            }
        });
    </script>
</x-layouts.app>