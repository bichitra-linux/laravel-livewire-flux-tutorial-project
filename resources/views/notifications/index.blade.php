<x-layouts.app.sidebar>
    <flux:main container class="space-y-6">
        {{-- Header --}}
        <div class="flex items-center justify-between">
            <div>
                <flux:heading size="xl">Notifications</flux:heading>
                <flux:subheading>Manage your notifications</flux:subheading>
            </div>
            
            <div class="flex gap-2">
                @if(auth()->user()->unreadNotifications->count() > 0)
                    <form action="{{ route('notifications.markAllRead') }}" method="POST">
                        @csrf
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 active:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Mark All Read
                        </button>
                    </form>
                @endif
                
                <form action="{{ route('notifications.clearRead') }}" method="POST">
                    @csrf
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-500 active:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                        Clear Read
                    </button>
                </form>
            </div>
        </div>

        {{-- Notifications List --}}
        <div class="bg-white dark:bg-zinc-800 shadow overflow-hidden sm:rounded-lg">
            @forelse($notifications as $notification)
                @php
                    $data = $notification->data;
                    $icon = $data['icon'] ?? '🔔';
                @endphp
                
                <div class="px-4 py-5 border-b border-zinc-200 dark:border-zinc-700 last:border-b-0 {{ $notification->read_at ? '' : 'bg-blue-50 dark:bg-blue-900/10' }}">
                    <div class="flex items-start gap-4">
                        {{-- Icon --}}
                        <div class="text-3xl">{{ $icon }}</div>
                        
                        {{-- Content --}}
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-zinc-900 dark:text-zinc-100">
                                {{ $data['message'] }}
                            </p>
                            <p class="text-xs text-zinc-500 dark:text-zinc-400 mt-1">
                                {{ $notification->created_at->diffForHumans() }}
                            </p>
                        </div>
                        
                        {{-- Actions --}}
                        <div class="flex items-center gap-2">
                            @if(isset($data['action_url']))
                                <form action="{{ route('notifications.markAsRead', $notification->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="text-sm text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                                        View
                                    </button>
                                </form>
                            @endif
                            
                            <form action="{{ route('notifications.destroy', $notification->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-sm text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </form>
                        </div>
                        
                        {{-- Unread indicator --}}
                        @if(!$notification->read_at)
                            <div class="w-2 h-2 bg-blue-500 rounded-full shrink-0"></div>
                        @endif
                    </div>
                </div>
            @empty
                <div class="px-4 py-12 text-center text-zinc-500 dark:text-zinc-400">
                    No notifications yet
                </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        @if($notifications->hasPages())
            <div class="mt-6">
                {{ $notifications->links() }}
            </div>
        @endif
    </flux:main>
</x-layouts.app.sidebar>