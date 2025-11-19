<x-blog-header>
    <div class="min-h-screen bg-gray-50 dark:bg-gray-900">
        
        {{-- Hero Section with Search & Filters --}}
        <div class="relative overflow-hidden dark:bg-gray-900 py-16">
            
            <div class="relative max-w-7xl mx-auto px-6">
                {{-- Page Title --}}
                <div class="text-center mb-8">
                    <h1 class="text-4xl md:text-5xl font-extrabold text-gray-900 dark:text-white mb-3">
                        Explore All Stories
                    </h1>
                    <p class="text-lg text-gray-600 dark:text-gray-400 max-w-2xl mx-auto">
                        Discover insightful articles, trending topics, and expert perspectives
                    </p>
                </div>

                {{-- Enhanced Search Bar --}}
                <form method="GET" action="{{ route('public.posts.index') }}" class="max-w-2xl mx-auto mb-6">
                    <div class="relative">
                        <input type="text" 
                            name="search" 
                            value="{{ request('search') }}" 
                            placeholder="Search articles, topics, authors..." 
                            class="w-full px-6 py-4 pl-14 pr-32 rounded-full bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-4 focus:ring-blue-500/50 shadow-lg border-2 border-gray-200 dark:border-gray-600" />
                        
                        <svg class="absolute left-5 top-1/2 -translate-y-1/2 w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        
                        <button type="submit" class="absolute right-2 top-1/2 -translate-y-1/2 px-6 py-2 bg-linear-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white rounded-full font-semibold shadow-lg transition-all duration-200 transform hover:scale-105">
                            Search
                        </button>
                    </div>
                    
                    {{-- Preserve filters --}}
                    @if(request('category'))
                        <input type="hidden" name="category" value="{{ request('category') }}">
                    @endif
                    @if(request('sort'))
                        <input type="hidden" name="sort" value="{{ request('sort') }}">
                    @endif
                </form>

                {{-- Category Pills --}}
                <div class="flex items-center justify-center gap-3 flex-wrap">
                    <a href="{{ route('public.posts.index') }}"
                        class="shrink-0 px-5 py-2.5 rounded-full text-sm font-semibold transition-all duration-300 {{ !request('category') ? 'bg-linear-to-r from-blue-600 to-purple-600 text-white shadow-xl scale-105' : 'bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600 shadow-md' }}">
                        🌟 All Posts
                    </a>
                    @foreach($categories as $cat)
                        <a href="{{ route('public.posts.index', ['category' => $cat->slug]) }}"
                            class="shrink-0 px-5 py-2.5 rounded-full text-sm font-semibold transition-all duration-300 {{ request('category') === $cat->slug ? 'bg-linear-to-r from-blue-600 to-purple-600 text-white shadow-xl scale-105' : 'bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600 shadow-md' }}">
                            {{ $cat->name }}
                        </a>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-6 -mt-8 relative z-10">
            
            {{-- Filter Controls Card --}}
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-6 mb-8">
                <div class="flex flex-col lg:flex-row items-start lg:items-center justify-between gap-4">
                    
                    {{-- Results Info --}}
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <span class="text-sm font-semibold text-gray-700 dark:text-gray-300">
                            Showing {{ $posts->count() }} of {{ $posts->total() }} articles
                        </span>
                    </div>

                    {{-- Sort Dropdown --}}
                    <div class="flex items-center gap-3">
                        <label class="text-sm font-semibold text-gray-700 dark:text-gray-300">
                            Sort By:
                        </label>
                        <form method="GET" action="{{ route('public.posts.index') }}">
                            <select name="sort" 
                                onchange="this.form.submit()"
                                class="px-4 py-2.5 pr-10 rounded-xl bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white font-medium focus:outline-none focus:ring-2 focus:ring-blue-500 cursor-pointer hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors duration-200">
                                <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest First</option>
                                <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Oldest First</option>
                                <option value="most_viewed" {{ request('sort') == 'most_viewed' ? 'selected' : '' }}>Most Viewed</option>
                                <option value="title_asc" {{ request('sort') == 'title_asc' ? 'selected' : '' }}>Title A-Z</option>
                                <option value="title_desc" {{ request('sort') == 'title_desc' ? 'selected' : '' }}>Title Z-A</option>
                            </select>
                            
                            {{-- Preserve filters --}}
                            @if(request('category'))
                                <input type="hidden" name="category" value="{{ request('category') }}">
                            @endif
                            @if(request('search'))
                                <input type="hidden" name="search" value="{{ request('search') }}">
                            @endif
                        </form>
                    </div>
                </div>
            </div>

            {{-- Active Filters Display --}}
            @if(request('category') || request('search') || request('sort') || request('tag'))
                <div class="bg-blue-50 dark:bg-blue-900/20 border-l-4 border-blue-500 rounded-lg p-4 mb-6 flex items-start justify-between">
                    <div class="flex items-center gap-2 flex-wrap">
                        <svg class="w-5 h-5 text-blue-600 dark:text-blue-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                        </svg>
                        <span class="text-sm font-semibold text-gray-700 dark:text-gray-300">Active Filters:</span>
                        
                        @if(request('search'))
                            <span class="px-3 py-1 bg-white dark:bg-gray-700 rounded-full text-sm font-medium text-gray-800 dark:text-gray-200 border border-gray-200 dark:border-gray-600">
                                🔍 "{{ request('search') }}"
                            </span>
                        @endif
                        
                        @if(request('category'))
                            @php $category = $categories->firstWhere('slug', request('category')) @endphp
                            @if($category)
                                <span class="px-3 py-1 bg-white dark:bg-gray-700 rounded-full text-sm font-medium text-gray-800 dark:text-gray-200 border border-gray-200 dark:border-gray-600">
                                    {{ $category->name }}
                                </span>
                            @endif
                        @endif

                        @if(request('tag'))
                            <span class="px-3 py-1 bg-white dark:bg-gray-700 rounded-full text-sm font-medium text-gray-800 dark:text-gray-200 border border-gray-200 dark:border-gray-600">
                                🏷️ #{{ request('tag') }}
                            </span>
                        @endif
                    </div>
                    
                    <a href="{{ route('public.posts.index') }}" 
                        class="shrink-0 text-sm font-semibold text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-200 flex items-center gap-1">
                        Clear All
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </a>
                </div>
            @endif

            {{-- Posts Grid --}}
            @if($posts->count() > 0)
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
                    @foreach($posts as $post)
                        <article class="group bg-white dark:bg-gray-800 rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl transform hover:-translate-y-2 transition-all duration-500 border border-gray-100 dark:border-gray-700">
                            
                            {{-- Post Image with Overlay --}}
                            <div class="relative h-56 overflow-hidden">
                                @if($post->image)
                                    <img src="{{ asset('storage/' . $post->image) }}" 
                                        alt="{{ $post->title }}"
                                        loading="lazy"
                                        class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                                @else
                                    <div class="w-full h-full bg-linear-to-br from-blue-400 via-purple-400 to-pink-400 flex items-center justify-center">
                                        <svg class="w-20 h-20 text-white/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                @endif
                                
                                {{-- Category Badge --}}
                                @if($post->category)
                                    <div class="absolute top-4 left-4">
                                        <span class="px-3 py-1.5 bg-white/95 dark:bg-gray-800/95 backdrop-blur-sm text-blue-600 dark:text-blue-400 rounded-full text-xs font-bold shadow-lg">
                                            {{ $post->category->name }}
                                        </span>
                                    </div>
                                @endif
                                
                                {{-- Reading Time Badge --}}
                                <div class="absolute top-4 right-4">
                                    <span class="px-3 py-1 bg-black/60 backdrop-blur-sm text-white rounded-full text-xs font-semibold flex items-center gap-1">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        {{ ceil(str_word_count(strip_tags($post->content)) / 200) }} min
                                    </span>
                                </div>
                            </div>
                            
                            <div class="p-6">
                                {{-- Meta Info --}}
                                <div class="flex items-center gap-2 text-xs text-gray-500 dark:text-gray-400 mb-3 flex-wrap">
                                    <div class="flex items-center gap-1">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                        <span class="font-medium">{{ $post->user->name ?? 'Staff' }}</span>
                                    </div>
                                    <span class="text-gray-300 dark:text-gray-600">•</span>
                                    <div class="flex items-center gap-1">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        <span>{{ $post->created_at->format('M d, Y') }}</span>
                                    </div>
                                    <span class="text-gray-300 dark:text-gray-600">•</span>
                                    <div class="flex items-center gap-1">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                        <span class="font-semibold">{{ $post->formatted_views }}</span>
                                    </div>
                                </div>
                                
                                {{-- Title --}}
                                <h3 class="font-bold text-xl text-gray-900 dark:text-white mb-3 leading-tight line-clamp-2 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors duration-200">
                                    <a href="{{ route('public.posts.show', $post->slug) }}">
                                        {{ $post->title }}
                                    </a>
                                </h3>
                                
                                {{-- Excerpt --}}
                                <p class="text-sm text-gray-600 dark:text-gray-400 line-clamp-3 leading-relaxed mb-4">
                                    {{ Str::limit(strip_tags($post->content), 140) }}
                                </p>
                                
                                {{-- Tags --}}
                                @if($post->tags->isNotEmpty())
                                    <div class="flex flex-wrap gap-2 mb-4">
                                        @foreach($post->tags->take(3) as $tag)
                                            <a href="{{ route('public.posts.index', ['tag' => $tag->slug]) }}"
                                                class="px-2 py-1 bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-400 rounded-md text-xs font-medium hover:bg-blue-100 dark:hover:bg-blue-900/30 hover:text-blue-600 dark:hover:text-blue-400 transition-all duration-200">
                                                #{{ $tag->name }}
                                            </a>
                                        @endforeach
                                    </div>
                                @endif
                                
                                {{-- Footer --}}
                                <div class="flex items-center justify-between pt-4 border-t border-gray-100 dark:border-gray-700">
                                    <a href="{{ route('public.posts.show', $post->slug) }}"
                                        class="inline-flex items-center gap-2 text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-200 font-semibold text-sm group/link">
                                        Read Article
                                        <svg class="w-4 h-4 group-hover/link:translate-x-1 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                                        </svg>
                                    </a>
                                    
                                    {{-- Reactions Preview --}}
                                    @if($post->reactions->count() > 0)
                                        <x-post-reactions :post="$post" :compact="true" />
                                    @else
                                        <span class="text-xs text-gray-400 dark:text-gray-500 flex items-center gap-1">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                            </svg>
                                            Be first to react
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>

                {{-- Enhanced Pagination --}}
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6">
                    {{ $posts->links() }}
                </div>
            @else
                {{-- Empty State --}}
                <div class="text-center py-20 bg-white dark:bg-gray-800 rounded-2xl shadow-lg">
                    <div class="inline-flex items-center justify-center w-24 h-24 bg-linear-to-br from-blue-100 to-purple-100 dark:from-blue-900/20 dark:to-purple-900/20 rounded-full mb-6">
                        <svg class="w-12 h-12 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">No Posts Found</h3>
                    <p class="text-gray-600 dark:text-gray-400 mb-6 max-w-md mx-auto">
                        @if(request('category') || request('search') || request('tag'))
                            We couldn't find any posts matching your criteria. Try adjusting your filters or search terms.
                        @else
                            There are no published posts available at the moment. Check back soon!
                        @endif
                    </p>
                    <a href="{{ route('public.posts.index') }}" 
                        class="inline-flex items-center gap-2 px-6 py-3 bg-linear-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white font-semibold rounded-xl shadow-lg transition-all duration-200 transform hover:scale-105">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                        </svg>
                        View All Posts
                    </a>
                </div>
            @endif
        </div>
    </div>
</x-blog-header>
<x-footer />