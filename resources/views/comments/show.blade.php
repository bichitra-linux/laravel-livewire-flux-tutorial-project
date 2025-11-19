<x-layouts.app :title="'Comment Details'">
    <div class="container mx-auto px-4 py-8">
        
        {{-- Back Button --}}
        <div class="mb-6">
            <a href="{{ route('comments.index') }}" class="inline-flex items-center gap-2 text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Back to Comments
            </a>
        </div>

        {{-- Success Message --}}
        @if(session('success'))
            <div class="mb-6 p-4 bg-green-50 dark:bg-green-900/20 border-l-4 border-green-500 rounded-lg">
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    <p class="text-green-800 dark:text-green-200 font-medium">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        <div class="grid gap-6 lg:grid-cols-3">
            {{-- Main Comment --}}
            <div class="lg:col-span-2">
                <div class="bg-white dark:bg-zinc-800 rounded-xl shadow-lg overflow-hidden">
                    {{-- Header --}}
                    <div class="bg-linear-to-r from-blue-600 to-purple-600 p-6 text-white">
                        <div class="flex items-center justify-between mb-4">
                            <h1 class="text-2xl font-bold">Comment Details</h1>
                            @if($comment->is_approved)
                                <span class="flex items-center gap-1 px-3 py-1 bg-green-500/20 text-green-100 text-sm font-semibold rounded-full">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                    Approved
                                </span>
                            @else
                                <span class="flex items-center gap-1 px-3 py-1 bg-orange-500/20 text-orange-100 text-sm font-semibold rounded-full">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                                    </svg>
                                    Pending
                                </span>
                            @endif
                        </div>

                        {{-- Author Info --}}
                        <div class="flex items-center gap-4">
                            <div class="w-16 h-16 rounded-full bg-white/20 backdrop-blur-sm flex items-center justify-center text-2xl font-bold border-4 border-white/30">
                                {{ $comment->user->initials() }}
                            </div>
                            <div>
                                <p class="text-xl font-bold">{{ $comment->user->name }}</p>
                                <p class="text-blue-100">{{ $comment->user->email }}</p>
                                <p class="text-sm text-blue-100 mt-1">
                                    {{ $comment->created_at->format('M d, Y \a\t h:i A') }}
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- Comment Content --}}
                    <div class="p-6">
                        @if($comment->parent)
                            <div class="mb-6 p-4 bg-blue-50 dark:bg-blue-900/20 border-l-4 border-blue-500 rounded-lg">
                                <p class="text-sm font-medium text-blue-800 dark:text-blue-400 mb-2">
                                    Reply to comment by {{ $comment->parent->user->name }}:
                                </p>
                                <p class="text-sm text-gray-700 dark:text-gray-300 italic">
                                    "{{ Str::limit($comment->parent->content, 100) }}"
                                </p>
                            </div>
                        @endif

                        <div class="prose dark:prose-invert max-w-none">
                            <p class="text-gray-900 dark:text-white text-lg leading-relaxed">
                                {!! $comment->safe_content !!}
                            </p>
                        </div>

                        {{-- Related Post --}}
                        <div class="mt-6 p-4 bg-gray-50 dark:bg-gray-900/50 rounded-lg">
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-400 mb-2">
                                Comment on post:
                            </p>
                            <a href="{{ route('public.posts.show', $comment->post) }}" 
                                class="text-blue-600 dark:text-blue-400 hover:underline font-semibold text-lg flex items-center gap-2"
                                target="_blank">
                                {{ $comment->post->title }}
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                </svg>
                            </a>
                        </div>
                    </div>

                    {{-- Action Buttons --}}
                    <div class="border-t border-gray-200 dark:border-gray-700 p-6 bg-gray-50 dark:bg-gray-900/50">
                        <div class="flex gap-3">
                            @if(!$comment->is_approved)
                                <form action="{{ route('comments.approve', $comment) }}" method="POST" class="flex-1">
                                    @csrf
                                    <button type="submit" 
                                        class="w-full px-6 py-3 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-lg transition-colors flex items-center justify-center gap-2">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        Approve Comment
                                    </button>
                                </form>
                            @else
                                <form action="{{ route('comments.reject', $comment) }}" method="POST" class="flex-1">
                                    @csrf
                                    <button type="submit" 
                                        class="w-full px-6 py-3 bg-orange-600 hover:bg-orange-700 text-white font-semibold rounded-lg transition-colors flex items-center justify-center gap-2">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        Mark as Pending
                                    </button>
                                </form>
                            @endif

                            <form action="{{ route('comments.destroy', $comment) }}" method="POST" 
                                onsubmit="return confirm('Are you sure you want to delete this comment? This will also delete all replies.')"
                                class="flex-1">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                    class="w-full px-6 py-3 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-lg transition-colors flex items-center justify-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                    Delete Comment
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                {{-- Replies Section --}}
                @if($comment->replies->count() > 0)
                    <div class="mt-6 bg-white dark:bg-zinc-800 rounded-xl shadow-lg overflow-hidden">
                        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                            <h2 class="text-xl font-bold text-gray-900 dark:text-white flex items-center gap-2">
                                <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path>
                                </svg>
                                Replies ({{ $comment->replies->count() }})
                            </h2>
                        </div>

                        <div class="divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach($comment->replies as $reply)
                                <div class="p-6 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                    <div class="flex items-start gap-4">
                                        <div class="w-12 h-12 rounded-full bg-linear-to-br from-blue-500 to-purple-500 flex items-center justify-center shadow-md shrink-0">
                                            <span class="text-white font-bold">{{ $reply->user->initials() }}</span>
                                        </div>
                                        <div class="flex-1">
                                            <div class="flex items-center justify-between mb-2">
                                                <div>
                                                    <p class="font-semibold text-gray-900 dark:text-white">{{ $reply->user->name }}</p>
                                                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ $reply->created_at->diffForHumans() }}</p>
                                                </div>
                                                @if($reply->is_approved)
                                                    <span class="px-2 py-1 bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-400 text-xs font-semibold rounded-full">
                                                        Approved
                                                    </span>
                                                @else
                                                    <span class="px-2 py-1 bg-orange-100 dark:bg-orange-900/30 text-orange-800 dark:text-orange-400 text-xs font-semibold rounded-full">
                                                        Pending
                                                    </span>
                                                @endif
                                            </div>
                                            <p class="text-gray-700 dark:text-gray-300">{!! $reply->safe_content !!}</p>
                                            
                                            <div class="flex gap-2 mt-3">
                                                @if(!$reply->is_approved)
                                                    <form action="{{ route('comments.approve', $reply) }}" method="POST" class="inline">
                                                        @csrf
                                                        <button type="submit" 
                                                            class="px-3 py-1 bg-green-600 hover:bg-green-700 text-white text-xs font-semibold rounded transition-colors">
                                                            Approve
                                                        </button>
                                                    </form>
                                                @else
                                                    <form action="{{ route('comments.reject', $reply) }}" method="POST" class="inline">
                                                        @csrf
                                                        <button type="submit" 
                                                            class="px-3 py-1 bg-orange-600 hover:bg-orange-700 text-white text-xs font-semibold rounded transition-colors">
                                                            Pending
                                                        </button>
                                                    </form>
                                                @endif
                                                
                                                <form action="{{ route('comments.destroy', $reply) }}" method="POST" 
                                                    onsubmit="return confirm('Are you sure you want to delete this reply?')"
                                                    class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" 
                                                        class="px-3 py-1 bg-red-600 hover:bg-red-700 text-white text-xs font-semibold rounded transition-colors">
                                                        Delete
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            {{-- Sidebar --}}
            <div class="space-y-6">
                {{-- Comment Stats --}}
                <div class="bg-white dark:bg-zinc-800 rounded-xl shadow-lg p-6">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Comment Info</h3>
                    <div class="space-y-3">
                        <div class="flex items-center justify-between py-2 border-b border-gray-200 dark:border-gray-700">
                            <span class="text-sm text-gray-600 dark:text-gray-400">Type</span>
                            <span class="text-sm font-semibold text-gray-900 dark:text-white">
                                {{ $comment->isReply() ? 'Reply' : 'Comment' }}
                            </span>
                        </div>
                        <div class="flex items-center justify-between py-2 border-b border-gray-200 dark:border-gray-700">
                            <span class="text-sm text-gray-600 dark:text-gray-400">Status</span>
                            <span class="text-sm font-semibold text-gray-900 dark:text-white">
                                {{ $comment->is_approved ? 'Approved' : 'Pending' }}
                            </span>
                        </div>
                        <div class="flex items-center justify-between py-2 border-b border-gray-200 dark:border-gray-700">
                            <span class="text-sm text-gray-600 dark:text-gray-400">Replies</span>
                            <span class="text-sm font-semibold text-gray-900 dark:text-white">
                                {{ $comment->replies->count() }}
                            </span>
                        </div>
                        <div class="flex items-center justify-between py-2">
                            <span class="text-sm text-gray-600 dark:text-gray-400">Created</span>
                            <span class="text-sm font-semibold text-gray-900 dark:text-white">
                                {{ $comment->created_at->format('M d, Y') }}
                            </span>
                        </div>
                    </div>
                </div>

                {{-- Post Preview --}}
                <div class="bg-white dark:bg-zinc-800 rounded-xl shadow-lg p-6">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Related Post</h3>
                    @if($comment->post->image)
                        <img src="{{ asset('storage/' . $comment->post->image) }}" 
                            alt="{{ $comment->post->title }}"
                            class="w-full h-32 object-cover rounded-lg mb-4">
                    @endif
                    <h4 class="font-semibold text-gray-900 dark:text-white mb-2">
                        {{ $comment->post->title }}
                    </h4>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">
                        {{ Str::limit(strip_tags($comment->post->content), 100) }}
                    </p>
                    <a href="{{ route('public.posts.show', $comment->post) }}" 
                        target="_blank"
                        class="inline-flex items-center gap-2 text-blue-600 dark:text-blue-400 hover:underline text-sm font-medium">
                        View Full Post
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>