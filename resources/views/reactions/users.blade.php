<x-blog-header>
    <div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-12">
        <div class="max-w-3xl mx-auto px-6">
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-8">
                {{-- Back Button --}}
                <a href="{{ route('public.posts.show', $post) }}" 
                    class="inline-flex items-center gap-2 text-blue-600 dark:text-blue-400 hover:underline mb-6">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back to post
                </a>

                {{-- Header --}}
                <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">
                    Reactions
                </h2>
                <p class="text-gray-600 dark:text-gray-400 mb-6">
                    People who reacted to "{{ Str::limit($post->title, 50) }}"
                </p>

                {{-- Filter by Reaction Type --}}
                <div class="flex items-center gap-2 mb-6 overflow-x-auto pb-2">
                    <a href="{{ route('reactions.users', $post) }}" 
                        class="px-4 py-2 rounded-full text-sm font-medium transition-colors {{ !request('type') ? 'bg-blue-600 text-white' : 'bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600' }}">
                        All ({{ $post->total_reactions }})
                    </a>
                    @foreach(['like', 'love', 'care', 'haha', 'wow', 'sad', 'angry'] as $reactionType)
                        @php
                            $count = $post->reactions()->where('type', $reactionType)->count();
                        @endphp
                        @if($count > 0)
                            <a href="{{ route('reactions.users', [$post, $reactionType]) }}" 
                                class="px-4 py-2 rounded-full text-sm font-medium transition-colors flex items-center gap-1 {{ $type === $reactionType ? 'bg-blue-600 text-white' : 'bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600' }}">
                                <span class="text-lg">
                                    {{ match($reactionType) {
                                        'like' => '👍',
                                        'love' => '❤️',
                                        'care' => '🤗',
                                        'haha' => '😂',
                                        'wow' => '😮',
                                        'sad' => '😢',
                                        'angry' => '😠',
                                    } }}
                                </span>
                                <span>{{ $count }}</span>
                            </a>
                        @endif
                    @endforeach
                </div>

                {{-- Reactions List --}}
                @if($reactions->count() > 0)
                    <div class="space-y-3">
                        @foreach($reactions as $reaction)
                            <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-700 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors">
                                <div class="flex items-center gap-4">
                                    {{-- User Avatar --}}
                                    <div class="w-12 h-12 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 text-white flex items-center justify-center font-bold text-lg">
                                        {{ strtoupper(substr($reaction->user->name, 0, 1)) }}
                                    </div>
                                    
                                    {{-- User Info --}}
                                    <div>
                                        <p class="font-semibold text-gray-900 dark:text-white">
                                            {{ $reaction->user->name }}
                                        </p>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">
                                            {{ $reaction->created_at->diffForHumans() }}
                                        </p>
                                    </div>
                                </div>
                                
                                {{-- Reaction Emoji --}}
                                <span class="text-3xl">{{ $reaction->emoji }}</span>
                            </div>
                        @endforeach
                    </div>

                    {{-- Pagination --}}
                    @if($reactions->hasPages())
                        <div class="mt-8">
                            {{ $reactions->links() }}
                        </div>
                    @endif
                @else
                    <div class="text-center py-12">
                        <div class="text-6xl mb-4">😢</div>
                        <p class="text-gray-600 dark:text-gray-400 text-lg">
                            No reactions yet. Be the first to react!
                        </p>
                        <a href="{{ route('public.posts.show', $post) }}" 
                            class="mt-4 inline-block px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors">
                            View Post
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-blog-header>
<x-footer />