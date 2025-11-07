<x-layouts.app.sidebar :title="'Posts'">
    <flux:main container class="space-y-6">
        {{-- Header Section --}}
        <div class="bg-white dark:bg-zinc-800 rounded-xl p-6 shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-zinc-900 dark:text-white flex items-center gap-3">
                        <svg class="w-8 h-8 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Posts Management
                    </h1>
                    <p class="text-zinc-600 dark:text-zinc-400 mt-2">Create, edit, and manage your blog posts.</p>
                </div>
                <div class="hidden md:block">
                    <a href="{{ route('posts.create') }}" 
                        class="flex items-center gap-2 bg-linear-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white px-6 py-3 rounded-lg font-semibold transition-all duration-200 shadow-lg hover:shadow-xl">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Create New Post
                    </a>
                </div>
            </div>
        </div>

        {{-- Stats Cards --}}
        @php
            $totalCount = $posts->total();
            $publishedCount = \App\Models\Post::where('status', \App\Enums\PostStatus::Published)->count();
            $draftCount = \App\Models\Post::where('status', \App\Enums\PostStatus::Draft)->count();
            $archivedCount = \App\Models\Post::where('status', \App\Enums\PostStatus::Archived)->count();
        @endphp

        <div class="grid gap-4 md:grid-cols-4">
            {{-- Total Posts --}}
            <div class="bg-white dark:bg-zinc-800 rounded-xl p-6 shadow-lg hover:shadow-xl transition-shadow duration-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-zinc-600 dark:text-zinc-400">Total Posts</p>
                        <p class="text-3xl font-bold text-zinc-900 dark:text-white mt-2">{{ number_format($totalCount) }}</p>
                        <p class="text-xs text-zinc-500 dark:text-zinc-400 mt-1">All posts</p>
                    </div>
                    <div class="p-3 rounded-full bg-blue-100 dark:bg-blue-900/30">
                        <svg class="w-8 h-8 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            {{-- Published Posts --}}
            <div class="bg-white dark:bg-zinc-800 rounded-xl p-6 shadow-lg hover:shadow-xl transition-shadow duration-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-zinc-600 dark:text-zinc-400">Published</p>
                        <p class="text-3xl font-bold text-zinc-900 dark:text-white mt-2">{{ number_format($publishedCount) }}</p>
                        <p class="text-xs text-green-600 dark:text-green-400 mt-1">Live posts</p>
                    </div>
                    <div class="p-3 rounded-full bg-green-100 dark:bg-green-900/30">
                        <svg class="w-8 h-8 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            {{-- Draft Posts --}}
            <div class="bg-white dark:bg-zinc-800 rounded-xl p-6 shadow-lg hover:shadow-xl transition-shadow duration-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-zinc-600 dark:text-zinc-400">Drafts</p>
                        <p class="text-3xl font-bold text-zinc-900 dark:text-white mt-2">{{ number_format($draftCount) }}</p>
                        <p class="text-xs text-yellow-600 dark:text-yellow-400 mt-1">In progress</p>
                    </div>
                    <div class="p-3 rounded-full bg-yellow-100 dark:bg-yellow-900/30">
                        <svg class="w-8 h-8 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            {{-- Archived Posts --}}
            <div class="bg-white dark:bg-zinc-800 rounded-xl p-6 shadow-lg hover:shadow-xl transition-shadow duration-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-zinc-600 dark:text-zinc-400">Archived</p>
                        <p class="text-3xl font-bold text-zinc-900 dark:text-white mt-2">{{ number_format($archivedCount) }}</p>
                        <p class="text-xs text-gray-600 dark:text-gray-400 mt-1">Hidden posts</p>
                    </div>
                    <div class="p-3 rounded-full bg-gray-100 dark:bg-gray-700">
                        <svg class="w-8 h-8 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        {{-- Posts List --}}
        <div class="bg-white dark:bg-zinc-800 rounded-xl shadow-lg overflow-hidden">
            <div class="p-6">
                @if($posts->count() > 0)
                    <div class="space-y-4">
                        @foreach($posts as $post)
                            <div class="border border-zinc-200 dark:border-zinc-700 rounded-lg p-5 hover:shadow-md hover:border-blue-300 dark:hover:border-blue-600 transition-all duration-200 group">
                                <div class="flex gap-4">
                                    {{-- Image Thumbnail --}}
                                    @if($post->image)
                                        <div class="shrink-0">
                                            <img src="{{ asset('storage/' . $post->image) }}" 
                                                alt="{{ $post->title }}" 
                                                class="w-32 h-32 object-cover rounded-lg border-2 border-zinc-200 dark:border-zinc-700 group-hover:border-blue-300 dark:group-hover:border-blue-600 transition-colors">
                                        </div>
                                    @else
                                        <div class="shrink-0 w-32 h-32 rounded-lg bg-linear-to-br from-blue-500 to-purple-500 flex items-center justify-center">
                                            <svg class="w-16 h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                            </svg>
                                        </div>
                                    @endif
                                    
                                    {{-- Post Content --}}
                                    <div class="flex-1 min-w-0">
                                        <div class="flex justify-between items-start gap-4">
                                            <div class="flex-1 min-w-0">
                                                {{-- Title --}}
                                                <h4 class="text-xl font-bold text-zinc-900 dark:text-white mb-2 line-clamp-1 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">
                                                    {{ $post->title }}
                                                </h4>
                                                
                                                {{-- Excerpt --}}
                                                <p class="text-sm text-zinc-600 dark:text-zinc-400 mb-3 line-clamp-2">
                                                    {{ Str::limit(strip_tags($post->content), 200) }}
                                                </p>
                                                
                                                {{-- Tags --}}
                                                @if($post->tags->count() > 0)
                                                    <div class="flex flex-wrap gap-2 mb-3">
                                                        @foreach($post->tags->take(3) as $tag)
                                                            <span class="bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-300 text-xs font-medium px-2.5 py-1 rounded-full">
                                                                #{{ $tag->name }}
                                                            </span>
                                                        @endforeach
                                                        @if($post->tags->count() > 3)
                                                            <span class="text-xs text-zinc-500 dark:text-zinc-400 px-2 py-1">
                                                                +{{ $post->tags->count() - 3 }} more
                                                            </span>
                                                        @endif
                                                    </div>
                                                @endif
                                                
                                                {{-- Meta Info --}}
                                                <div class="flex flex-wrap items-center gap-3 text-xs text-zinc-500 dark:text-zinc-400">
                                                    <span class="flex items-center gap-1">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                        </svg>
                                                        {{ $post->created_at->format('M d, Y') }}
                                                    </span>
                                                    
                                                    @if($post->category)
                                                        <span class="flex items-center gap-1">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                                            </svg>
                                                            {{ $post->category->name }}
                                                        </span>
                                                    @endif
                                                    
                                                    <span class="flex items-center gap-1">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                        </svg>
                                                        {{ number_format($post->views) }} views
                                                    </span>
                                                    
                                                    {{-- Status Badge --}}
                                                    <span class="px-2.5 py-1 rounded-full text-xs font-semibold
                                                        @if($post->status->value === 'published') 
                                                            bg-green-100 dark:bg-green-900/30 dark:text-green-400
                                                        @elseif($post->status->value === 'draft')
                                                        @else text-gray-800
                                                        @endif">
                                                        {{ $post->status->label() }}
                                                    </span>
                                                </div>
                                            </div>
                                            
                                            {{-- Action Buttons --}}
                                            <div class="flex flex-col gap-2">
                                                <a href="{{ route('posts.show', $post) }}" 
                                                    class="flex items-center justify-center gap-1 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition-colors text-sm whitespace-nowrap"
                                                    title="View">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                    </svg>
                                                    View
                                                </a>
                                                
                                                <a href="{{ route('posts.edit', $post) }}" 
                                                    class="flex items-center justify-center gap-1 px-4 py-2 bg-yellow-600 hover:bg-yellow-700 text-white rounded-lg font-medium transition-colors text-sm whitespace-nowrap"
                                                    title="Edit">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                    </svg>
                                                    Edit
                                                </a>
                                                
                                                <form action="{{ route('posts.destroy', $post) }}" method="POST" 
                                                    onsubmit="return confirm('Are you sure you want to delete this post?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" 
                                                        class="w-full flex items-center justify-center gap-1 px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg font-medium transition-colors text-sm whitespace-nowrap"
                                                        title="Delete">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                        </svg>
                                                        Delete
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- Pagination --}}
                    @if($posts->hasPages())
                        <div class="mt-6">
                            {{ $posts->links() }}
                        </div>
                    @endif
                @else
                    {{-- Empty State --}}
                    <div class="text-center py-16">
                        <svg class="mx-auto h-24 w-24 text-zinc-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <h3 class="text-xl font-bold text-zinc-900 dark:text-white mb-2">No posts yet</h3>
                        <p class="text-zinc-600 dark:text-zinc-400 mb-6">Get started by creating your first blog post.</p>
                        <a href="{{ route('posts.create') }}" 
                            class="inline-flex items-center gap-2 bg-linear-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white px-6 py-3 rounded-lg font-semibold transition-all duration-200">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            Create Your First Post
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </flux:main>
</x-layouts.app.sidebar>