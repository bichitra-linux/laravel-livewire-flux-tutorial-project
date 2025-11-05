<div 
    x-data="commentSection()" 
    x-init="init()"
    class="mt-12 bg-white dark:bg-gray-800 rounded-xl p-8 shadow-lg">
    
    {{-- Header --}}
    <div class="flex items-center justify-between mb-6">
        <h3 class="text-2xl font-bold text-gray-900 dark:text-white">
            Comments (<span x-text="commentCount">{{ $commentsCount }}</span>)
        </h3>
        
        {{-- Subtle Live indicator - only shows when checking --}}
        <div class="flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400">
            <div x-show="isChecking" class="relative" style="display: none;">
                <div class="w-2 h-2 bg-blue-500 rounded-full animate-pulse"></div>
            </div>
            <span x-show="!isChecking" class="text-xs">
                <span x-show="hasNewComments" class="text-blue-500 cursor-pointer" @click="refresh()" style="display: none;">
                    🔄 New comments available - Click to refresh
                </span>
            </span>
        </div>
    </div>

    {{-- Success/Error Messages --}}
    <div x-show="showMessage" 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 transform -translate-y-2"
         x-transition:enter-end="opacity-100 transform translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         style="display: none;">
        @if (session()->has('message'))
            <div class="mb-4 p-4 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg">
                <p class="text-green-800 dark:text-green-200">{{ session('message') }}</p>
            </div>
        @endif

        @if (session()->has('error'))
            <div class="mb-4 p-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg">
                <p class="text-red-800 dark:text-red-200">{{ session('error') }}</p>
            </div>
        @endif
    </div>

    {{-- Comment Form --}}
    @auth
        <div class="mb-8">
            @if($parentId)
                <div class="mb-3 flex items-center justify-between p-3 bg-blue-50 dark:bg-blue-900/20 rounded-lg border border-blue-200 dark:border-blue-800"
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 transform -translate-y-2"
                     x-transition:enter-end="opacity-100 transform translate-y-0">
                    <p class="text-sm text-blue-800 dark:text-blue-200">
                        Replying to <strong>{{ $replyToUsername }}</strong>
                    </p>
                    <button wire:click="cancelReply" class="text-blue-600 hover:text-blue-800 dark:text-blue-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            @endif

            <form wire:submit.prevent="postComment">
                <div class="mb-4">
                    <label for="content" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        {{ $parentId ? 'Your reply' : 'Add a comment' }}
                    </label>
                    <textarea
                        wire:model.defer="content"
                        id="comment-input"
                        rows="3"
                        maxlength="1000"
                        placeholder="Share your thoughts..."
                        class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white resize-none transition-all"
                    ></textarea>
                    @error('content')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                        <span x-text="$wire.content.length">0</span>/1000 characters
                    </p>
                </div>
                
                <div class="flex gap-2">
                    <button
                        type="submit"
                        wire:loading.attr="disabled"
                        wire:loading.class="opacity-50 cursor-not-allowed"
                        class="px-6 py-2 bg-blue-600 hover:bg-blue-700 disabled:bg-gray-400 text-white font-semibold rounded-lg transition-all duration-200">
                        <span wire:loading.remove wire:target="postComment">
                            {{ $parentId ? 'Post Reply' : 'Post Comment' }}
                        </span>
                        <span wire:loading wire:target="postComment" class="flex items-center gap-2">
                            <svg class="animate-spin h-4 w-4" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Posting...
                        </span>
                    </button>
                    
                    @if($parentId)
                        <button
                            type="button"
                            wire:click="cancelReply"
                            class="px-6 py-2 bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 font-semibold rounded-lg transition-colors duration-200">
                            Cancel
                        </button>
                    @endif
                </div>
            </form>
        </div>
    @else
        <div class="mb-8 p-6 bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 rounded-xl border-2 border-blue-200 dark:border-blue-800">
            <div class="flex items-center gap-4">
                <svg class="w-12 h-12 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                </svg>
                <div>
                    <h4 class="text-lg font-bold text-gray-900 dark:text-white mb-1">Join the conversation</h4>
                    <p class="text-gray-700 dark:text-gray-300 mb-3">
                        <a href="{{ route('login') }}" class="text-blue-600 dark:text-blue-400 hover:underline font-semibold">Sign in</a>
                        or
                        <a href="{{ route('register') }}" class="text-blue-600 dark:text-blue-400 hover:underline font-semibold">create an account</a>
                        to leave a comment.
                    </p>
                </div>
            </div>
        </div>
    @endauth

    {{-- Comments List with smooth transitions --}}
    <div class="space-y-6">
        @forelse($comments as $comment)
            <div class="comment-item" 
                 id="comment-{{ $comment->id }}"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 transform translate-y-4"
                 x-transition:enter-end="opacity-100 transform translate-y-0">
                {{-- Parent Comment --}}
                <div class="flex gap-4">
                    <div class="flex-shrink-0">
                        <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center">
                            <span class="text-white font-bold text-sm">{{ $comment->user->initials() }}</span>
                        </div>
                    </div>

                    <div class="flex-1 min-w-0">
                        @if($editingCommentId === $comment->id)
                            {{-- Edit Mode --}}
                            <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4"
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="opacity-0"
                                 x-transition:enter-end="opacity-100">
                                <form wire:submit.prevent="updateComment">
                                    <textarea
                                        wire:model.defer="editingContent"
                                        rows="3"
                                        maxlength="1000"
                                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-600 dark:text-white resize-none mb-2 transition-all"
                                    ></textarea>
                                    @error('editingContent')
                                        <p class="text-sm text-red-600 dark:text-red-400 mb-2">{{ $message }}</p>
                                    @enderror
                                    <div class="flex gap-2">
                                        <button type="submit" wire:loading.attr="disabled" class="px-4 py-1.5 bg-blue-600 hover:bg-blue-700 text-white text-sm rounded-lg transition-colors">
                                            <span wire:loading.remove>Save</span>
                                            <span wire:loading>Saving...</span>
                                        </button>
                                        <button type="button" wire:click="cancelEdit" class="px-4 py-1.5 bg-gray-300 dark:bg-gray-600 hover:bg-gray-400 dark:hover:bg-gray-500 text-gray-700 dark:text-gray-300 text-sm rounded-lg transition-colors">
                                            Cancel
                                        </button>
                                    </div>
                                </form>
                            </div>
                        @else
                            {{-- View Mode --}}
                            <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                                <div class="flex items-center justify-between mb-2">
                                    <div class="flex items-center gap-2">
                                        <span class="font-semibold text-gray-900 dark:text-white">{{ $comment->user->name }}</span>
                                        <span class="text-sm text-gray-500 dark:text-gray-400">
                                            {{ $comment->created_at->diffForHumans() }}
                                        </span>
                                        @if($comment->created_at != $comment->updated_at)
                                            <span class="text-xs text-gray-500 dark:text-gray-400">(edited)</span>
                                        @endif
                                    </div>

                                    @auth
                                        @if($comment->canEdit() || $comment->canDelete())
                                            <div x-data="{ open: false }" class="relative">
                                                <button @click="open = !open" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors">
                                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z"></path>
                                                    </svg>
                                                </button>

                                                <div x-show="open" 
                                                     @click.away="open = false" 
                                                     x-transition:enter="transition ease-out duration-100"
                                                     x-transition:enter-start="opacity-0 scale-95"
                                                     x-transition:enter-end="opacity-100 scale-100"
                                                     x-transition:leave="transition ease-in duration-75"
                                                     x-transition:leave-start="opacity-100 scale-100"
                                                     x-transition:leave-end="opacity-0 scale-95"
                                                     class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 rounded-lg shadow-lg py-1 z-10" 
                                                     style="display: none;">
                                                    @if($comment->canEdit())
                                                        <button wire:click="startEdit({{ $comment->id }}, '{{ addslashes($comment->content) }}')" class="w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                                                            Edit
                                                        </button>
                                                    @endif
                                                    @if($comment->canDelete())
                                                        <button wire:click="deleteComment({{ $comment->id }})" wire:confirm="Are you sure you want to delete this comment?" class="w-full text-left px-4 py-2 text-sm text-red-600 dark:text-red-400 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                                                            Delete
                                                        </button>
                                                    @endif
                                                </div>
                                            </div>
                                        @endif
                                    @endauth
                                </div>

                                <p class="text-gray-700 dark:text-gray-300 whitespace-pre-wrap">{{ $comment->content }}</p>
                            </div>

                            @auth
                                <button wire:click="startReply({{ $comment->id }}, '{{ $comment->user->name }}')" class="mt-2 text-sm text-blue-600 dark:text-blue-400 hover:underline font-medium transition-colors">
                                    Reply
                                </button>
                            @endauth
                        @endif

                        {{-- Replies --}}
                        @if($comment->replies->count() > 0)
                            <div class="mt-4 ml-8 space-y-4">
                                @foreach($comment->replies as $reply)
                                    <div class="flex gap-3">
                                        <div class="flex-shrink-0">
                                            <div class="w-8 h-8 bg-gradient-to-br from-green-500 to-teal-600 rounded-full flex items-center justify-center">
                                                <span class="text-white font-bold text-xs">{{ $reply->user->initials() }}</span>
                                            </div>
                                        </div>

                                        <div class="flex-1 min-w-0">
                                            @if($editingCommentId === $reply->id)
                                                {{-- Edit Reply --}}
                                                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-3">
                                                    <form wire:submit.prevent="updateComment">
                                                        <textarea
                                                            wire:model.defer="editingContent"
                                                            rows="2"
                                                            maxlength="1000"
                                                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-600 dark:text-white resize-none mb-2 transition-all"
                                                        ></textarea>
                                                        <div class="flex gap-2">
                                                            <button type="submit" wire:loading.attr="disabled" class="px-3 py-1 bg-blue-600 hover:bg-blue-700 text-white text-xs rounded transition-colors">
                                                                <span wire:loading.remove>Save</span>
                                                                <span wire:loading>Saving...</span>
                                                            </button>
                                                            <button type="button" wire:click="cancelEdit" class="px-3 py-1 bg-gray-300 dark:bg-gray-600 text-gray-700 dark:text-gray-300 text-xs rounded transition-colors">
                                                                Cancel
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            @else
                                                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-3">
                                                    <div class="flex items-center justify-between mb-1">
                                                        <div class="flex items-center gap-2">
                                                            <span class="font-semibold text-sm text-gray-900 dark:text-white">{{ $reply->user->name }}</span>
                                                            <span class="text-xs text-gray-500 dark:text-gray-400">
                                                                {{ $reply->created_at->diffForHumans() }}
                                                            </span>
                                                            @if($reply->created_at != $reply->updated_at)
                                                                <span class="text-xs text-gray-500 dark:text-gray-400">(edited)</span>
                                                            @endif
                                                        </div>

                                                        @auth
                                                            @if($reply->canEdit() || $reply->canDelete())
                                                                <div x-data="{ open: false }" class="relative">
                                                                    <button @click="open = !open" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors">
                                                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                                            <path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z"></path>
                                                                        </svg>
                                                                    </button>

                                                                    <div x-show="open" 
                                                                         @click.away="open = false"
                                                                         x-transition:enter="transition ease-out duration-100"
                                                                         x-transition:enter-start="opacity-0 scale-95"
                                                                         x-transition:enter-end="opacity-100 scale-100"
                                                                         x-transition:leave="transition ease-in duration-75"
                                                                         x-transition:leave-start="opacity-100 scale-100"
                                                                         x-transition:leave-end="opacity-0 scale-95"
                                                                         class="absolute right-0 mt-2 w-40 bg-white dark:bg-gray-800 rounded-lg shadow-lg py-1 z-10" 
                                                                         style="display: none;">
                                                                        @if($reply->canEdit())
                                                                            <button wire:click="startEdit({{ $reply->id }}, '{{ addslashes($reply->content) }}')" class="w-full text-left px-3 py-1.5 text-xs text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                                                                                Edit
                                                                            </button>
                                                                        @endif
                                                                        @if($reply->canDelete())
                                                                            <button wire:click="deleteComment({{ $reply->id }})" wire:confirm="Delete this reply?" class="w-full text-left px-3 py-1.5 text-xs text-red-600 dark:text-red-400 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                                                                                Delete
                                                                            </button>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        @endauth
                                                    </div>
                                                    <p class="text-sm text-gray-700 dark:text-gray-300 whitespace-pre-wrap">{{ $reply->content }}</p>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center py-12">
                <svg class="w-20 h-20 mx-auto text-gray-400 dark:text-gray-500 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                </svg>
                <p class="text-xl text-gray-600 dark:text-gray-400 mb-2">No comments yet</p>
                <p class="text-gray-500 dark:text-gray-500">Be the first to share your thoughts!</p>
            </div>
        @endforelse
    </div>

    {{-- Alpine.js for smooth updates --}}
    <script>
        function commentSection() {
            return {
                isChecking: false,
                hasNewComments: false,
                lastCheck: {{ $lastUpdated }},
                commentCount: {{ $commentsCount }},
                showMessage: {{ session()->has('message') || session()->has('error') ? 'true' : 'false' }},
                checkInterval: null,

                init() {
                    // Check for new comments every 10 seconds (less intrusive)
                    this.checkInterval = setInterval(() => {
                        this.checkForNewComments();
                    }, 10000);

                    // Auto-hide flash messages after 3 seconds
                    if (this.showMessage) {
                        setTimeout(() => {
                            this.showMessage = false;
                        }, 3000);
                    }

                    // Listen for Livewire events
                    Livewire.on('focusCommentInput', () => {
                        document.getElementById('comment-input')?.focus();
                    });

                    Livewire.on('comment-posted', () => {
                        this.lastCheck = Math.floor(Date.now() / 1000);
                        this.hasNewComments = false;
                    });
                },

                checkForNewComments() {
                    this.isChecking = true;
                    
                    // Subtle check without refreshing the component
                    fetch(`/api/posts/{{ $post->id }}/comments/check?since=${this.lastCheck}`)
                        .then(response => response.json())
                        .then(data => {
                            this.isChecking = false;
                            if (data.hasNew) {
                                this.hasNewComments = true;
                            }
                        })
                        .catch(() => {
                            this.isChecking = false;
                        });
                },

                refresh() {
                    this.hasNewComments = false;
                    this.lastCheck = Math.floor(Date.now() / 1000);
                    @this.call('refreshComments');
                }
            }
        }
    </script>
</div>