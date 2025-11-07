<div class="mt-12 bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden">

    {{-- Collapsible Header (Always Visible) --}}
    <button wire:click="toggleSection"
        class="w-full flex items-center justify-between p-6 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-all group">
        <div class="flex items-center gap-3">
            <div class="p-2 rounded-lg bg-blue-100 dark:bg-blue-900/30 group-hover:scale-110 transition-transform">
                <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z">
                    </path>
                </svg>
            </div>
            <div class="text-left">
                <h3 class="text-xl font-bold text-gray-900 dark:text-white flex items-center gap-2">
                    Comments ({{ $commentsCount }})
                </h3>
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    @if($isExpanded)
                        Click to collapse
                    @else
                        Click to view and add comments
                    @endif
                </p>
            </div>
        </div>

        <div class="flex items-center gap-3">
            {{-- Quick Stats (Visible when collapsed) --}}
            @if(!$isExpanded)
                <div class="flex items-center gap-4 mr-4">
                    @if($commentsCount > 0)
                        <div class="flex items-center gap-2 px-3 py-1.5 bg-blue-100 dark:bg-blue-900/30 rounded-full">
                            <svg class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z">
                                </path>
                            </svg>
                            <span class="text-sm font-semibold text-blue-800 dark:text-blue-200">{{ $commentsCount }}</span>
                        </div>
                        @auth
                            <span class="text-sm text-gray-600 dark:text-gray-400 hidden sm:inline">Join the discussion</span>
                        @else
                            <span class="text-sm text-gray-600 dark:text-gray-400 hidden sm:inline">Sign in to comment</span>
                        @endauth
                    @else
                        <span class="text-sm text-gray-500 dark:text-gray-400 hidden sm:inline">Be the first to comment</span>
                    @endif
                </div>
            @endif

            {{-- Expand/Collapse Icon --}}
            <div
                class="p-2 rounded-lg bg-gray-100 dark:bg-gray-700 group-hover:bg-gray-200 dark:group-hover:bg-gray-600 transition-colors">
                @if($isExpanded)
                    <svg class="w-5 h-5 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                    </svg>
                @else
                    <svg class="w-5 h-5 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                @endif
            </div>
        </div>
    </button>

    {{-- Expandable Content --}}
    @if($isExpanded)
        <div x-data x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 transform -translate-y-4"
            x-transition:enter-end="opacity-100 transform translate-y-0"
            class="border-t border-gray-200 dark:border-gray-700">

            <div class="p-6 sm:p-8">
                {{-- Sort & Control Bar --}}
                <div class="flex items-center justify-between mb-6 pb-4 border-b border-gray-200 dark:border-gray-700">
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 4h13M3 8h9m-9 4h6m4 0l4-4m0 0l4 4m-4-4v12"></path>
                        </svg>
                        <select wire:model.live="sortBy"
                            class="px-3 py-1.5 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-300 focus:ring-2 focus:ring-blue-500 transition-all">
                            <option value="latest">Latest First</option>
                            <option value="oldest">Oldest First</option>
                            <option value="most_replies">Most Replies</option>
                        </select>
                    </div>

                    <div class="flex items-center gap-2">
                        {{-- Refresh Button --}}
                        <button wire:click="refreshComments" wire:loading.attr="disabled"
                            wire:loading.class="opacity-50 cursor-not-allowed"
                            class="flex items-center gap-2 px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-600 transition-all shadow-sm hover:shadow-md"
                            title="Refresh Comments">
                            <svg wire:loading.remove wire:target="refreshComments" class="w-4 h-4" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
                                </path>
                            </svg>
                            <svg wire:loading wire:target="refreshComments" class="animate-spin w-4 h-4" fill="none"
                                viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                                </circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                </path>
                            </svg>
                            <span wire:loading.remove wire:target="refreshComments">Refresh</span>
                            <span wire:loading wire:target="refreshComments">Refreshing...</span>
                        </button>

                        {{-- Close Button --}}
                        <button wire:click="toggleSection"
                            class="p-2 text-gray-500 hover:text-red-600 dark:text-gray-400 dark:hover:text-red-400 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors"
                            title="Close Comments">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </div>

                {{-- Success/Error Messages --}}
                @if (session()->has('message'))
                    <div class="mb-4 p-4 bg-green-50 dark:bg-green-900/20 border-l-4 border-green-500 rounded-lg" x-data
                        x-init="setTimeout(() => $el.remove(), 5000)">
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            <p class="text-green-800 dark:text-green-200 font-medium">{{ session('message') }}</p>
                        </div>
                    </div>
                @endif

                @if (session()->has('error'))
                    <div class="mb-4 p-4 bg-red-50 dark:bg-red-900/20 border-l-4 border-red-500 rounded-lg" x-data
                        x-init="setTimeout(() => $el.remove(), 5000)">
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-red-600 dark:text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            <p class="text-red-800 dark:text-red-200 font-medium">{{ session('error') }}</p>
                        </div>
                    </div>
                @endif

                {{-- Comment Form --}}
                @auth
                    <div class="mb-8">
                        @if($parentId)
                            <div
                                class="mb-3 flex items-center justify-between p-4 bg-linear-to-r from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 rounded-xl border-2 border-blue-200 dark:border-blue-700">
                                <div class="flex items-center gap-2">
                                    <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"></path>
                                    </svg>
                                    <p class="text-sm text-blue-800 dark:text-blue-200 font-medium">
                                        Replying to <strong class="font-bold">{{ $replyToUsername }}</strong>
                                    </p>
                                </div>
                                <button wire:click="cancelReply"
                                    class="p-1.5 text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-200 hover:bg-blue-100 dark:hover:bg-blue-900/30 rounded-lg transition-all">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </div>
                        @endif

                        <form wire:submit.prevent="postComment" class="relative">
                            <div class="mb-4">
                                <label for="content" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                    {{ $parentId ? 'Your reply' : 'Add a comment' }}
                                </label>
                                <div class="relative">
                                    <textarea wire:model.defer="content" id="comment-input" rows="4" maxlength="1000"
                                        placeholder="Share your thoughts... (Markdown supported)"
                                        class="w-full px-4 py-3 pr-20 border-2 border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white resize-none transition-all shadow-sm hover:border-gray-400 dark:hover:border-gray-500"></textarea>
                                    <div
                                        class="absolute bottom-3 right-3 text-xs text-gray-500 dark:text-gray-400 font-mono bg-white dark:bg-gray-700 px-2 py-1 rounded">
                                        {{ strlen($content) }}/1000
                                    </div>
                                </div>
                                @error('content')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-400 flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div class="flex items-center justify-between">
                                <div class="flex gap-2">
                                    <button type="submit" wire:loading.attr="disabled"
                                        wire:loading.class="opacity-50 cursor-not-allowed"
                                        class="px-6 py-2.5 bg-linear-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 disabled:from-gray-400 disabled:to-gray-500 text-white font-semibold rounded-lg transition-all duration-200 shadow-md hover:shadow-lg transform hover:-translate-y-0.5 active:translate-y-0">
                                        <span wire:loading.remove wire:target="postComment" class="flex items-center gap-2">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                                            </svg>
                                            {{ $parentId ? 'Post Reply' : 'Post Comment' }}
                                        </span>
                                        <span wire:loading wire:target="postComment" class="flex items-center gap-2">
                                            <svg class="animate-spin h-4 w-4" fill="none" viewBox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                                    stroke-width="4"></circle>
                                                <path class="opacity-75" fill="currentColor"
                                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                                </path>
                                            </svg>
                                            Posting...
                                        </span>
                                    </button>

                                    @if($parentId)
                                        <button type="button" wire:click="cancelReply"
                                            class="px-6 py-2.5 bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 font-semibold rounded-lg transition-colors duration-200">
                                            Cancel
                                        </button>
                                    @endif
                                </div>

                                <p class="text-xs text-gray-500 dark:text-gray-400 flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Markdown supported
                                </p>
                            </div>
                        </form>
                    </div>
                @else
                    <div
                        class="mb-8 p-6 bg-linear-to-r from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 rounded-xl border-2 border-blue-200 dark:border-blue-800">
                        <div class="flex items-start gap-4">
                            <div class="shrink-0 p-3 bg-blue-100 dark:bg-blue-900/40 rounded-full">
                                <svg class="w-8 h-8 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z">
                                    </path>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <h4 class="text-lg font-bold text-gray-900 dark:text-white mb-2">Join the conversation</h4>
                                <p class="text-gray-700 dark:text-gray-300 mb-4">
                                    Sign in to share your thoughts and engage with the community.
                                </p>
                                <div class="flex gap-3">
                                    <a href="{{ route('login') }}"
                                        class="inline-flex items-center gap-2 px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg shadow-md hover:shadow-lg transition-all duration-200 transform hover:-translate-y-0.5">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1">
                                            </path>
                                        </svg>
                                        Sign In
                                    </a>
                                    <a href="{{ route('register') }}"
                                        class="inline-flex items-center gap-2 px-5 py-2.5 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 font-semibold rounded-lg border-2 border-gray-300 dark:border-gray-600 shadow-sm hover:shadow-md transition-all duration-200">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z">
                                            </path>
                                        </svg>
                                        Create Account
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endauth

                {{-- Comments List with Threading --}}
                <div class="space-y-6" wire:key="comments-list-{{ $lastUpdated }}" x-data="{ 
                             threadsExpanded: @entangle('allThreadsExpanded').live 
                         }" @threads-collapsed.window="threadsExpanded = false"
                    @threads-expanded.window="threadsExpanded = true">
                    @forelse($comments as $comment)
                        <div x-data="{ 
                                        expanded: threadsExpanded,
                                        isNew: {{ $comment->created_at->gt(now()->subMinutes(5)) ? 'true' : 'false' }}
                                    }" class="comment-item" id="comment-{{ $comment->id }}"
                            wire:key="comment-{{ $comment->id }}">

                            {{-- Parent Comment --}}
                            <div class="relative" :class="{ 'ring-2 ring-blue-400 dark:ring-blue-600 rounded-xl': isNew }">
                                {{-- New Comment Badge --}}
                                <div x-show="isNew" x-transition
                                    class="absolute -top-2 -right-2 px-2 py-1 bg-blue-600 text-white text-xs font-bold rounded-full shadow-lg animate-pulse z-10">
                                    NEW
                                </div>

                                <div
                                    class="flex gap-4 p-4 bg-linear-to-r from-gray-50 to-transparent dark:from-gray-700/50 dark:to-transparent rounded-xl hover:from-gray-100 dark:hover:from-gray-700 transition-all">
                                    {{-- Avatar --}}
                                    <div class="shrink-0">
                                        <div
                                            class="w-12 h-12 bg-linear-to-br from-blue-500 via-purple-500 to-pink-500 rounded-full flex items-center justify-center shadow-lg ring-2 ring-white dark:ring-gray-800">
                                            <span class="text-white font-bold text-lg">{{ $comment->user->initials() }}</span>
                                        </div>
                                    </div>

                                    <div class="flex-1 min-w-0">
                                        @if($editingCommentId === $comment->id)
                                            {{-- Edit Mode --}}
                                            <div
                                                class="bg-white dark:bg-gray-800 rounded-xl p-4 border-2 border-blue-300 dark:border-blue-700 shadow-lg">
                                                <form wire:submit.prevent="updateComment">
                                                    <textarea wire:model.defer="editingContent" rows="3" maxlength="1000"
                                                        class="w-full px-3 py-2 border-2 border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white resize-none mb-3 transition-all"></textarea>
                                                    @error('editingContent')
                                                        <p class="text-sm text-red-600 dark:text-red-400 mb-2">{{ $message }}</p>
                                                    @enderror
                                                    <div class="flex gap-2">
                                                        <button type="submit" wire:loading.attr="disabled"
                                                            class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-lg transition-all shadow-md hover:shadow-lg">
                                                            <span wire:loading.remove wire:target="updateComment">Save
                                                                Changes</span>
                                                            <span wire:loading wire:target="updateComment"
                                                                class="flex items-center gap-2">
                                                                <svg class="animate-spin h-4 w-4" fill="none" viewBox="0 0 24 24">
                                                                    <circle class="opacity-25" cx="12" cy="12" r="10"
                                                                        stroke="currentColor" stroke-width="4"></circle>
                                                                    <path class="opacity-75" fill="currentColor"
                                                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                                                                </svg>
                                                                Saving...
                                                            </span>
                                                        </button>
                                                        <button type="button" wire:click="cancelEdit"
                                                            class="px-4 py-2 bg-gray-300 dark:bg-gray-600 hover:bg-gray-400 dark:hover:bg-gray-500 text-gray-700 dark:text-gray-300 text-sm font-semibold rounded-lg transition-colors">
                                                            Cancel
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        @else
                                            {{-- View Mode --}}
                                            <div>
                                                {{-- Comment Header --}}
                                                <div class="flex items-center justify-between mb-3">
                                                    <div class="flex items-center gap-3 flex-wrap">
                                                        <span
                                                            class="font-bold text-gray-900 dark:text-white">{{ $comment->user->name }}</span>
                                                        <span
                                                            class="text-sm text-gray-500 dark:text-gray-400 flex items-center gap-1">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                                viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                            </svg>
                                                            {{ $comment->created_at->diffForHumans() }}
                                                        </span>
                                                        @if($comment->created_at != $comment->updated_at)
                                                            <span
                                                                class="px-2 py-0.5 bg-yellow-100 dark:bg-yellow-900/30 text-yellow-800 dark:text-yellow-400 text-xs font-medium rounded-full">edited</span>
                                                        @endif
                                                        @if($comment->replies->count() > 0)
                                                            <span
                                                                class="px-2 py-0.5 bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-400 text-xs font-bold rounded-full flex items-center gap-1">
                                                                <svg class="w-3 h-3" fill="none" stroke="currentColor"
                                                                    viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                        stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6">
                                                                    </path>
                                                                </svg>
                                                                {{ $comment->replies->count() }}
                                                                {{ Str::plural('reply', $comment->replies->count()) }}
                                                            </span>
                                                        @endif
                                                    </div>

                                                    @auth
                                                        @if($comment->canEdit() || $comment->canDelete())
                                                            <div x-data="{ open: false }" class="relative">
                                                                <button @click="open = !open"
                                                                    class="p-2 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition-all">
                                                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                                                        <path
                                                                            d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z">
                                                                        </path>
                                                                    </svg>
                                                                </button>

                                                                <div x-show="open" @click.away="open = false"
                                                                    x-transition:enter="transition ease-out duration-100"
                                                                    x-transition:enter-start="opacity-0 scale-95"
                                                                    x-transition:enter-end="opacity-100 scale-100"
                                                                    x-transition:leave="transition ease-in duration-75"
                                                                    x-transition:leave-start="opacity-100"
                                                                    x-transition:leave-end="opacity-0 scale-95"
                                                                    class="absolute right-0 mt-2 w-56 bg-white dark:bg-gray-800 rounded-xl shadow-2xl border border-gray-200 dark:border-gray-700 py-2 z-10"
                                                                    style="display: none;">
                                                                    @if($comment->canEdit())
                                                                        <button
                                                                            wire:click="startEdit({{ $comment->id }}, '{{ addslashes($comment->content) }}')"
                                                                            class="w-full text-left px-4 py-2.5 text-sm text-gray-700 dark:text-gray-300 hover:bg-blue-50 dark:hover:bg-blue-900/30 transition-colors flex items-center gap-2">
                                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                                                viewBox="0 0 24 24">
                                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                                    stroke-width="2"
                                                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                                                                </path>
                                                                            </svg>
                                                                            Edit Comment
                                                                        </button>
                                                                    @endif
                                                                    @if($comment->canDelete())
                                                                        <button wire:click="deleteComment({{ $comment->id }})"
                                                                            wire:confirm="Are you sure you want to delete this comment and all its replies?"
                                                                            class="w-full text-left px-4 py-2.5 text-sm text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/30 transition-colors flex items-center gap-2">
                                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                                                viewBox="0 0 24 24">
                                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                                    stroke-width="2"
                                                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                                                </path>
                                                                            </svg>
                                                                            Delete Comment
                                                                        </button>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        @endif
                                                    @endauth
                                                </div>

                                                {{-- Comment Content --}}
                                                <div class="prose prose-sm dark:prose-invert max-w-none mb-3">
                                                    <p class="text-gray-700 dark:text-gray-300 leading-relaxed">
                                                        {{ preg_replace('/^\s+|\s+$/u', '', $comment->content) }}</p>
                                                </div>

                                                {{-- Comment Actions --}}
                                                <div class="flex items-center gap-4">
                                                    @auth
                                                        <button
                                                            wire:click="startReply({{ $comment->id }}, '{{ $comment->user->name }}')"
                                                            class="flex items-center gap-1.5 text-sm text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 font-medium transition-colors group">
                                                            <svg class="w-4 h-4 transform group-hover:translate-x-0.5 transition-transform"
                                                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                    d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"></path>
                                                            </svg>
                                                            Reply
                                                        </button>
                                                    @endauth

                                                    @if($comment->replies->count() > 0)
                                                        <button @click="expanded = !expanded"
                                                            class="flex items-center gap-1.5 text-sm text-gray-600 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-300 font-medium transition-colors">
                                                            <svg x-show="!expanded" class="w-4 h-4" fill="none" stroke="currentColor"
                                                                viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                    d="M19 9l-7 7-7-7"></path>
                                                            </svg>
                                                            <svg x-show="expanded" class="w-4 h-4" fill="none" stroke="currentColor"
                                                                viewBox="0 0 24 24" style="display: none;">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                    d="M5 15l7-7 7 7"></path>
                                                            </svg>
                                                            <span x-text="expanded ? 'Hide' : 'Show'"></span>
                                                            {{ $comment->replies->count() }}
                                                            {{ Str::plural('reply', $comment->replies->count()) }}
                                                        </button>
                                                    @endif
                                                </div>
                                            </div>
                                        @endif

                                        {{-- Threaded Replies --}}
                                        @if($comment->replies->count() > 0)
                                            <div x-show="expanded" x-transition:enter="transition ease-out duration-300"
                                                x-transition:enter-start="opacity-0 transform -translate-y-2"
                                                x-transition:enter-end="opacity-100 transform translate-y-0"
                                                class="mt-6 ml-4 sm:ml-8 space-y-4 border-l-4 border-blue-200 dark:border-blue-800 pl-4 sm:pl-6">
                                                @foreach($comment->replies as $reply)
                                                    <div x-data="{ isNewReply: {{ $reply->created_at->gt(now()->subMinutes(5)) ? 'true' : 'false' }} }"
                                                        class="relative" wire:key="reply-{{ $reply->id }}">
                                                        {{-- Thread Connection Line --}}
                                                        <div
                                                            class="absolute -left-4 sm:-left-6 top-6 w-4 sm:w-6 h-0.5 bg-blue-200 dark:bg-blue-800">
                                                        </div>

                                                        {{-- New Reply Badge --}}
                                                        <div x-show="isNewReply" x-transition
                                                            class="absolute -top-2 -right-2 px-1.5 py-0.5 bg-green-600 text-white text-xs font-bold rounded-full shadow-lg animate-pulse z-10">
                                                            NEW
                                                        </div>

                                                        <div class="flex gap-3 p-3 bg-gray-50 dark:bg-gray-700/50 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-all"
                                                            :class="{ 'ring-2 ring-green-400 dark:ring-green-600': isNewReply }">
                                                            {{-- Reply Avatar --}}
                                                            <div class="shrink-0">
                                                                <div
                                                                    class="w-10 h-10 bg-linear-to-br from-green-500 via-teal-500 to-cyan-500 rounded-full flex items-center justify-center shadow-md ring-2 ring-white dark:ring-gray-700">
                                                                    <span
                                                                        class="text-white font-bold text-sm">{{ $reply->user->initials() }}</span>
                                                                </div>
                                                            </div>

                                                            <div class="flex-1 min-w-0">
                                                                @if($editingCommentId === $reply->id)
                                                                    {{-- Edit Reply --}}
                                                                    <div
                                                                        class="bg-white dark:bg-gray-800 rounded-lg p-3 border-2 border-blue-300 dark:border-blue-700 shadow-lg">
                                                                        <form wire:submit.prevent="updateComment">
                                                                            <textarea wire:model.defer="editingContent" rows="2"
                                                                                maxlength="1000"
                                                                                class="w-full px-3 py-2 border-2 border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white resize-none mb-2 transition-all"></textarea>
                                                                            <div class="flex gap-2">
                                                                                <button type="submit" wire:loading.attr="disabled"
                                                                                    class="px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold rounded-lg transition-all">
                                                                                    <span wire:loading.remove
                                                                                        wire:target="updateComment">Save</span>
                                                                                    <span wire:loading
                                                                                        wire:target="updateComment">Saving...</span>
                                                                                </button>
                                                                                <button type="button" wire:click="cancelEdit"
                                                                                    class="px-3 py-1.5 bg-gray-300 dark:bg-gray-600 text-gray-700 dark:text-gray-300 text-xs font-semibold rounded-lg transition-colors">
                                                                                    Cancel
                                                                                </button>
                                                                            </div>
                                                                        </form>
                                                                    </div>
                                                                @else
                                                                    {{-- View Reply --}}
                                                                    <div>
                                                                        <div class="flex items-center justify-between mb-2">
                                                                            <div class="flex items-center gap-2 flex-wrap">
                                                                                <span
                                                                                    class="font-semibold text-sm text-gray-900 dark:text-white">{{ $reply->user->name }}</span>
                                                                                <span
                                                                                    class="text-xs text-gray-500 dark:text-gray-400 flex items-center gap-1">
                                                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor"
                                                                                        viewBox="0 0 24 24">
                                                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                                                            stroke-width="2"
                                                                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z">
                                                                                        </path>
                                                                                    </svg>
                                                                                    {{ $reply->created_at->diffForHumans() }}
                                                                                </span>
                                                                                @if($reply->created_at != $reply->updated_at)
                                                                                    <span
                                                                                        class="px-1.5 py-0.5 bg-yellow-100 dark:bg-yellow-900/30 text-yellow-800 dark:text-yellow-400 text-xs font-medium rounded-full">edited</span>
                                                                                @endif
                                                                            </div>

                                                                            @auth
                                                                                @if($reply->canEdit() || $reply->canDelete())
                                                                                    <div x-data="{ open: false }" class="relative">
                                                                                        <button @click="open = !open"
                                                                                            class="p-1.5 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600 rounded-lg transition-all">
                                                                                            <svg class="w-4 h-4" fill="currentColor"
                                                                                                viewBox="0 0 20 20">
                                                                                                <path
                                                                                                    d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z">
                                                                                                </path>
                                                                                            </svg>
                                                                                        </button>

                                                                                        <div x-show="open" @click.away="open = false"
                                                                                            x-transition:enter="transition ease-out duration-100"
                                                                                            x-transition:enter-start="opacity-0 scale-95"
                                                                                            x-transition:enter-end="opacity-100 scale-100"
                                                                                            class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 rounded-lg shadow-xl border border-gray-200 dark:border-gray-700 py-1 z-10"
                                                                                            style="display: none;">
                                                                                            @if($reply->canEdit())
                                                                                                <button
                                                                                                    wire:click="startEdit({{ $reply->id }}, '{{ addslashes($reply->content) }}')"
                                                                                                    class="w-full text-left px-3 py-2 text-xs text-gray-700 dark:text-gray-300 hover:bg-blue-50 dark:hover:bg-blue-900/30 transition-colors flex items-center gap-2">
                                                                                                    <svg class="w-3 h-3" fill="none"
                                                                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                                                                        <path stroke-linecap="round"
                                                                                                            stroke-linejoin="round" stroke-width="2"
                                                                                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                                                                                        </path>
                                                                                                    </svg>
                                                                                                    Edit
                                                                                                </button>
                                                                                            @endif
                                                                                            @if($reply->canDelete())
                                                                                                <button wire:click="deleteComment({{ $reply->id }})"
                                                                                                    wire:confirm="Delete this reply?"
                                                                                                    class="w-full text-left px-3 py-2 text-xs text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/30 transition-colors flex items-center gap-2">
                                                                                                    <svg class="w-3 h-3" fill="none"
                                                                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                                                                        <path stroke-linecap="round"
                                                                                                            stroke-linejoin="round" stroke-width="2"
                                                                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                                                                        </path>
                                                                                                    </svg>
                                                                                                    Delete
                                                                                                </button>
                                                                                            @endif
                                                                                        </div>
                                                                                    </div>
                                                                                @endif
                                                                            @endauth
                                                                        </div>
                                                                        <p
                                                                            class="text-sm text-gray-700 dark:text-gray-300 leading-relaxed">
                                                                            {{ preg_replace('/^\s+|\s+$/u', '', $reply->content) }}</p>
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-16">
                            <div
                                class="inline-flex items-center justify-center w-20 h-20 bg-gray-100 dark:bg-gray-800 rounded-full mb-4">
                                <svg class="w-10 h-10 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z">
                                    </path>
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">No comments yet</h3>
                            <p class="text-gray-600 dark:text-gray-400 mb-6">Be the first to share your thoughts!</p>
                            @guest
                                <a href="{{ route('login') }}"
                                    class="inline-flex items-center gap-2 px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg shadow-md hover:shadow-lg transition-all duration-200 transform hover:-translate-y-0.5">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z">
                                        </path>
                                    </svg>
                                    Sign In to Comment
                                </a>
                            @endguest
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    @endif

    {{-- Alpine.js for Focus Input Event --}}
    @script
    <script>
        Livewire.on('focusCommentInput', () => {
            setTimeout(() => {
                document.getElementById('comment-input')?.focus();
            }, 100);
        });
    </script>
    @endscript
</div>