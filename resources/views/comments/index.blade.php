<x-layouts.app.sidebar :title="Comments">
    <div class="container mx-auto px-4 py-8">
        
        {{-- Header --}}
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-3xl font-bold text-zinc-900 dark:text-white flex items-center gap-3">
                    <div class="p-2 rounded-lg bg-blue-100 dark:bg-blue-900/30">
                        <svg class="w-8 h-8 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                        </svg>
                    </div>
                    Comments Management
                </h1>
                <p class="text-zinc-600 dark:text-zinc-400 mt-2">Moderate and manage all user comments</p>
            </div>
        </div>

        {{-- Statistics Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            {{-- Total Comments --}}
            <div class="bg-white dark:bg-zinc-800 rounded-xl p-6 shadow-lg hover:shadow-xl transition-all">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-zinc-600 dark:text-zinc-400">Total Comments</p>
                        <p class="text-3xl font-bold text-zinc-900 dark:text-white mt-2">{{ number_format($stats['total']) }}</p>
                        <p class="text-xs text-blue-600 dark:text-blue-400 mt-1">All time</p>
                    </div>
                    <div class="p-3 rounded-full bg-blue-100 dark:bg-blue-900/30">
                        <svg class="w-8 h-8 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            {{-- Pending Comments --}}
            <div class="bg-white dark:bg-zinc-800 rounded-xl p-6 shadow-lg hover:shadow-xl transition-all">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-zinc-600 dark:text-zinc-400">Pending</p>
                        <p class="text-3xl font-bold text-zinc-900 dark:text-white mt-2">{{ number_format($stats['pending']) }}</p>
                        <p class="text-xs text-orange-600 dark:text-orange-400 mt-1">Awaiting approval</p>
                    </div>
                    <div class="p-3 rounded-full bg-orange-100 dark:bg-orange-900/30">
                        <svg class="w-8 h-8 text-orange-600 dark:text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            {{-- Approved Comments --}}
            <div class="bg-white dark:bg-zinc-800 rounded-xl p-6 shadow-lg hover:shadow-xl transition-all">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-zinc-600 dark:text-zinc-400">Approved</p>
                        <p class="text-3xl font-bold text-zinc-900 dark:text-white mt-2">{{ number_format($stats['approved']) }}</p>
                        <p class="text-xs text-green-600 dark:text-green-400 mt-1">Published</p>
                    </div>
                    <div class="p-3 rounded-full bg-green-100 dark:bg-green-900/30">
                        <svg class="w-8 h-8 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            {{-- Today's Comments --}}
            <div class="bg-white dark:bg-zinc-800 rounded-xl p-6 shadow-lg hover:shadow-xl transition-all">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-zinc-600 dark:text-zinc-400">Today</p>
                        <p class="text-3xl font-bold text-zinc-900 dark:text-white mt-2">{{ number_format($stats['today']) }}</p>
                        <p class="text-xs text-purple-600 dark:text-purple-400 mt-1">New comments</p>
                    </div>
                    <div class="p-3 rounded-full bg-purple-100 dark:bg-purple-900/30">
                        <svg class="w-8 h-8 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        {{-- Success/Error Messages --}}
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

        {{-- Filters & Search --}}
        <div class="bg-white dark:bg-zinc-800 rounded-xl shadow-lg p-6 mb-6">
            <form method="GET" action="{{ route('comments.index') }}" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
                    {{-- Search --}}
                    <div class="lg:col-span-2">
                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                            <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                            Search
                        </label>
                        <input type="text" name="search" value="{{ request('search') }}" 
                            placeholder="Search comments, users, posts..."
                            class="w-full px-4 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-zinc-900 dark:text-white">
                    </div>

                    {{-- Status Filter --}}
                    <div>
                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">Status</label>
                        <select name="status" class="w-full px-4 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-zinc-900 dark:text-white">
                            <option value="">All Statuses</option>
                            <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        </select>
                    </div>

                    {{-- Type Filter --}}
                    <div>
                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">Type</label>
                        <select name="type" class="w-full px-4 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-zinc-900 dark:text-white">
                            <option value="">All Types</option>
                            <option value="parent" {{ request('type') == 'parent' ? 'selected' : '' }}>Comments</option>
                            <option value="reply" {{ request('type') == 'reply' ? 'selected' : '' }}>Replies</option>
                        </select>
                    </div>

                    {{-- Sort --}}
                    <div>
                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">Sort</label>
                        <select name="sort" class="w-full px-4 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-zinc-900 dark:text-white">
                            <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Latest First</option>
                            <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Oldest First</option>
                            <option value="most_replies" {{ request('sort') == 'most_replies' ? 'selected' : '' }}>Most Replies</option>
                        </select>
                    </div>
                </div>

                <div class="flex gap-2">
                    <button type="submit" class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition-colors flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                        </svg>
                        Apply Filters
                    </button>
                    <a href="{{ route('comments.index') }}" class="px-6 py-2 bg-zinc-200 dark:bg-zinc-700 hover:bg-zinc-300 dark:hover:bg-zinc-600 text-zinc-800 dark:text-white font-semibold rounded-lg transition-colors">
                        Clear
                    </a>
                </div>
            </form>
        </div>

        {{-- Bulk Actions Form --}}
        <form id="bulkForm" method="POST" class="bg-white dark:bg-zinc-800 rounded-xl shadow-lg overflow-hidden">
            @csrf
            
            {{-- Bulk Action Bar --}}
            <div id="bulkActionBar" class="hidden bg-blue-50 dark:bg-blue-900/20 border-b border-blue-200 dark:border-blue-800 p-4">
                <div class="flex items-center justify-between">
                    <span class="text-sm font-medium text-blue-800 dark:text-blue-200">
                        <span id="selectedCount">0</span> comment(s) selected
                    </span>
                    <div class="flex gap-2">
                        <button type="button" onclick="bulkAction('approve')" 
                            class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg text-sm font-semibold transition-colors flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Approve
                        </button>
                        <button type="button" onclick="bulkAction('delete')" 
                            class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg text-sm font-semibold transition-colors flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                            Delete
                        </button>
                        <button type="button" onclick="clearSelection()" 
                            class="px-4 py-2 bg-zinc-200 dark:bg-zinc-700 hover:bg-zinc-300 dark:hover:bg-zinc-600 text-zinc-800 dark:text-white rounded-lg text-sm font-semibold transition-colors">
                            Clear
                        </button>
                    </div>
                </div>
            </div>

            {{-- Comments Table --}}
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-zinc-50 dark:bg-zinc-900 border-b border-zinc-200 dark:border-zinc-700">
                        <tr>
                            <th class="px-6 py-4 text-left">
                                <input type="checkbox" id="selectAll" onclick="toggleSelectAll()" 
                                    class="w-4 h-4 rounded border-zinc-300 dark:border-zinc-600">
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-zinc-600 dark:text-zinc-400 uppercase tracking-wider">Author</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-zinc-600 dark:text-zinc-400 uppercase tracking-wider">Comment</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-zinc-600 dark:text-zinc-400 uppercase tracking-wider">Post</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-zinc-600 dark:text-zinc-400 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-zinc-600 dark:text-zinc-400 uppercase tracking-wider">Date</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-zinc-600 dark:text-zinc-400 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                        @forelse($comments as $comment)
                            <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-700/50 transition-colors">
                                <td class="px-6 py-4">
                                    <input type="checkbox" name="comment_ids[]" value="{{ $comment->id }}" 
                                        class="comment-checkbox w-4 h-4 rounded border-zinc-300 dark:border-zinc-600"
                                        onchange="updateBulkBar()">
                                </td>
                                
                                {{-- Author --}}
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-500 to-purple-500 flex items-center justify-center shadow-md">
                                            <span class="text-white font-bold text-sm">{{ $comment->user->initials() }}</span>
                                        </div>
                                        <div>
                                            <p class="font-semibold text-zinc-900 dark:text-white">{{ $comment->user->name }}</p>
                                            <p class="text-xs text-zinc-500 dark:text-zinc-400">{{ $comment->user->email }}</p>
                                        </div>
                                    </div>
                                </td>

                                {{-- Comment Content --}}
                                <td class="px-6 py-4 max-w-md">
                                    <div class="space-y-1">
                                        @if($comment->isReply())
                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-400 text-xs font-medium rounded-full">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"></path>
                                                </svg>
                                                Reply to #{{ $comment->parent_id }}
                                            </span>
                                        @endif
                                        <p class="text-sm text-zinc-700 dark:text-zinc-300 line-clamp-2">{{ $comment->getExcerpt(150) }}</p>
                                        @if($comment->replies->count() > 0)
                                            <span class="inline-flex items-center gap-1 text-xs text-zinc-500 dark:text-zinc-400">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path>
                                                </svg>
                                                {{ $comment->replies->count() }} {{ Str::plural('reply', $comment->replies->count()) }}
                                            </span>
                                        @endif
                                    </div>
                                </td>

                                {{-- Post --}}
                                <td class="px-6 py-4">
                                    <a href="{{ route('public.posts.show', $comment->post->id) }}" 
                                        class="text-sm text-blue-600 dark:text-blue-400 hover:underline font-medium"
                                        target="_blank">
                                        {{ Str::limit($comment->post->title, 30) }}
                                        <svg class="w-3 h-3 inline ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                        </svg>
                                    </a>
                                </td>

                                {{-- Status --}}
                                <td class="px-6 py-4">
                                    @if($comment->is_approved)
                                        <span class="inline-flex items-center gap-1 px-3 py-1 bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-400 text-xs font-semibold rounded-full">
                                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                            </svg>
                                            Approved
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 px-3 py-1 bg-orange-100 dark:bg-orange-900/30 text-orange-800 dark:text-orange-400 text-xs font-semibold rounded-full">
                                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                                            </svg>
                                            Pending
                                        </span>
                                    @endif
                                </td>

                                {{-- Date --}}
                                <td class="px-6 py-4">
                                    <div class="text-sm text-zinc-600 dark:text-zinc-400">
                                        <p class="font-medium">{{ $comment->created_at->format('M d, Y') }}</p>
                                        <p class="text-xs">{{ $comment->created_at->format('h:i A') }}</p>
                                    </div>
                                </td>

                                {{-- Actions --}}
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="{{ route('comments.show', $comment) }}" 
                                            class="p-2 text-blue-600 dark:text-blue-400 hover:bg-blue-100 dark:hover:bg-blue-900/30 rounded-lg transition-colors"
                                            title="View">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                        </a>

                                        @if(!$comment->is_approved)
                                            <form action="{{ route('comments.approve', $comment) }}" method="POST" class="inline">
                                                @csrf
                                                <button type="submit" 
                                                    class="p-2 text-green-600 dark:text-green-400 hover:bg-green-100 dark:hover:bg-green-900/30 rounded-lg transition-colors"
                                                    title="Approve">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                    </svg>
                                                </button>
                                            </form>
                                        @else
                                            <form action="{{ route('comments.reject', $comment) }}" method="POST" class="inline">
                                                @csrf
                                                <button type="submit" 
                                                    class="p-2 text-orange-600 dark:text-orange-400 hover:bg-orange-100 dark:hover:bg-orange-900/30 rounded-lg transition-colors"
                                                    title="Mark as Pending">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                    </svg>
                                                </button>
                                            </form>
                                        @endif

                                        <form action="{{ route('comments.destroy', $comment) }}" method="POST" class="inline"
                                            onsubmit="return confirm('Are you sure you want to delete this comment? This will also delete all replies.')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                class="p-2 text-red-600 dark:text-red-400 hover:bg-red-100 dark:hover:bg-red-900/30 rounded-lg transition-colors"
                                                title="Delete">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <svg class="w-16 h-16 text-zinc-400 dark:text-zinc-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                        </svg>
                                        <p class="text-zinc-600 dark:text-zinc-400 font-medium">No comments found</p>
                                        <p class="text-sm text-zinc-500 dark:text-zinc-500 mt-1">Try adjusting your filters</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if($comments->hasPages())
                <div class="border-t border-zinc-200 dark:border-zinc-700 p-6">
                    {{ $comments->links() }}
                </div>
            @endif
        </form>
    </div>

    {{-- Bulk Actions Script --}}
    @push('scripts')
    <script>
        function toggleSelectAll() {
            const selectAll = document.getElementById('selectAll');
            const checkboxes = document.querySelectorAll('.comment-checkbox');
            checkboxes.forEach(cb => cb.checked = selectAll.checked);
            updateBulkBar();
        }

        function updateBulkBar() {
            const checkboxes = document.querySelectorAll('.comment-checkbox:checked');
            const count = checkboxes.length;
            const bulkBar = document.getElementById('bulkActionBar');
            const countSpan = document.getElementById('selectedCount');
            
            if (count > 0) {
                bulkBar.classList.remove('hidden');
                countSpan.textContent = count;
            } else {
                bulkBar.classList.add('hidden');
            }

            // Update select all checkbox
            const selectAll = document.getElementById('selectAll');
            const allCheckboxes = document.querySelectorAll('.comment-checkbox');
            selectAll.checked = count === allCheckboxes.length && count > 0;
        }

        function clearSelection() {
            document.querySelectorAll('.comment-checkbox').forEach(cb => cb.checked = false);
            document.getElementById('selectAll').checked = false;
            updateBulkBar();
        }

        function bulkAction(action) {
            const form = document.getElementById('bulkForm');
            const checkboxes = document.querySelectorAll('.comment-checkbox:checked');
            
            if (checkboxes.length === 0) {
                alert('Please select at least one comment');
                return;
            }

            if (action === 'approve') {
                form.action = '{{ route("comments.bulk-approve") }}';
            } else if (action === 'delete') {
                if (!confirm(`Are you sure you want to delete ${checkboxes.length} comment(s)? This action cannot be undone.`)) {
                    return;
                }
                form.action = '{{ route("comments.bulk-delete") }}';
            }

            form.submit();
        }
    </script>
    @endpush
</x-layouts.app.sidebar>