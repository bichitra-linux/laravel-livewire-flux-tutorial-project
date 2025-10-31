<x-layouts.app :title="__('Newsletter')">
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Newsletter Subscribers
            </h2>
            <a href="{{ route('newsletter.export') }}" 
                class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                Export CSV
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Stats Cards --}}
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                <div class="bg-white dark:bg-gray-800 rounded-lg p-6 shadow-lg">
                    <div class="text-sm text-gray-600 dark:text-gray-400">Total Subscribers</div>
                    <div class="text-3xl font-bold text-gray-900 dark:text-white">{{ number_format($stats['total']) }}</div>
                </div>
                <div class="bg-white dark:bg-gray-800 rounded-lg p-6 shadow-lg">
                    <div class="text-sm text-gray-600 dark:text-gray-400">Active</div>
                    <div class="text-3xl font-bold text-green-600">{{ number_format($stats['active']) }}</div>
                </div>
                <div class="bg-white dark:bg-gray-800 rounded-lg p-6 shadow-lg">
                    <div class="text-sm text-gray-600 dark:text-gray-400">Unsubscribed</div>
                    <div class="text-3xl font-bold text-red-600">{{ number_format($stats['unsubscribed']) }}</div>
                </div>
                <div class="bg-white dark:bg-gray-800 rounded-lg p-6 shadow-lg">
                    <div class="text-sm text-gray-600 dark:text-gray-400">Today</div>
                    <div class="text-3xl font-bold text-blue-600">{{ number_format($stats['today']) }}</div>
                </div>
            </div>

            {{-- Subscribers Table --}}
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead>
                                <tr>
                                    <th class="px-6 py-3 bg-gray-50 dark:bg-gray-900 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                        Email
                                    </th>
                                    <th class="px-6 py-3 bg-gray-50 dark:bg-gray-900 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                        Name
                                    </th>
                                    <th class="px-6 py-3 bg-gray-50 dark:bg-gray-900 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                        Status
                                    </th>
                                    <th class="px-6 py-3 bg-gray-50 dark:bg-gray-900 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                        IP Address
                                    </th>
                                    <th class="px-6 py-3 bg-gray-50 dark:bg-gray-900 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                        Subscribed At
                                    </th>
                                    <th class="px-6 py-3 bg-gray-50 dark:bg-gray-900 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse($subscribers as $subscriber)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900 dark:text-white">
                                                {{ $subscriber->email }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-500 dark:text-gray-400">
                                                {{ $subscriber->name ?? 'N/A' }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($subscriber->is_subscribed)
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">
                                                    Active
                                                </span>
                                            @else
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400">
                                                    Unsubscribed
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-500 dark:text-gray-400" title="{{ $subscriber->user_agent }}">
                                                {{ $subscriber->ip_address ?? 'N/A' }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                            {{ $subscriber->subscribed_at?->format('M d, Y H:i') ?? 'N/A' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            <button 
                                                onclick="showDetails({{ json_encode($subscriber) }})"
                                                class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300">
                                                View Details
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">
                                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                                            </svg>
                                            <p class="mt-2">No subscribers yet.</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $subscribers->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- Details Modal --}}
    <div id="detailsModal" class="hidden fixed inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-xl bg-white dark:bg-gray-800">
            <div class="mt-3">
                <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white mb-4">Subscriber Details</h3>
                <div id="modalContent" class="mt-2 text-sm text-gray-600 dark:text-gray-400 space-y-2">
                    <!-- Content will be injected by JavaScript -->
                </div>
                <div class="mt-4">
                    <button 
                        onclick="closeModal()"
                        class="w-full px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
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
                <div class="space-y-3">
                    <div>
                        <strong class="text-gray-700 dark:text-gray-300">Email:</strong>
                        <p class="mt-1">${subscriber.email}</p>
                    </div>
                    <div>
                        <strong class="text-gray-700 dark:text-gray-300">Name:</strong>
                        <p class="mt-1">${subscriber.name || 'N/A'}</p>
                    </div>
                    <div>
                        <strong class="text-gray-700 dark:text-gray-300">Status:</strong>
                        <p class="mt-1">${subscriber.is_subscribed ? '✅ Active' : '❌ Unsubscribed'}</p>
                    </div>
                    <div>
                        <strong class="text-gray-700 dark:text-gray-300">IP Address:</strong>
                        <p class="mt-1">${subscriber.ip_address || 'N/A'}</p>
                    </div>
                    <div>
                        <strong class="text-gray-700 dark:text-gray-300">User Agent:</strong>
                        <p class="mt-1 text-xs break-all">${subscriber.user_agent || 'N/A'}</p>
                    </div>
                    <div>
                        <strong class="text-gray-700 dark:text-gray-300">Subscribed At:</strong>
                        <p class="mt-1">${subscriber.subscribed_at ? new Date(subscriber.subscribed_at).toLocaleString() : 'N/A'}</p>
                    </div>
                    ${subscriber.unsubscribed_at ? `
                    <div>
                        <strong class="text-gray-700 dark:text-gray-300">Unsubscribed At:</strong>
                        <p class="mt-1">${new Date(subscriber.unsubscribed_at).toLocaleString()}</p>
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
    </script>
</x-layouts.app>