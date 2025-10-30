<x-blog-header>
    <div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-12">
        <div class="max-w-7xl mx-auto px-6">
            {{-- Header Section --}}
            <div class="text-center mb-12">
                <h1 class="text-4xl font-extrabold text-gray-900 dark:text-white mb-4">Published Posts</h1>
                <p class="text-lg text-gray-600 dark:text-gray-300">Explore the latest stories and insights.</p>
            </div>

            {{-- Category Filters --}}
            <div class="mb-8 flex items-center gap-2 overflow-x-auto scrollbar-hide justify-center">
                <a href="{{ route('public.posts.index') }}"
                    class="px-4 py-2 rounded-full text-sm font-medium transition-all duration-200 {{ !request('category') ? 'bg-blue-600 text-white shadow-md' : 'bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600' }}">
                    All
                </a>
                @foreach($categories as $cat)
                    <a href="{{ route('public.posts.index', ['category' => $cat->slug]) }}"
                        class="px-4 py-2 rounded-full text-sm font-medium transition-all duration-200 {{ request('category') === $cat->slug ? 'bg-blue-600 text-white shadow-md' : 'bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600' }}">
                        {{ $cat->name }}
                    </a>
                @endforeach
            </div>

            {{-- Search and Sort Bar --}}
            <div class="mb-8 flex flex-col md:flex-row items-center justify-center gap-4">
                <form method="GET" action="{{ route('public.posts.index') }}"
                    class="flex items-center bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-full overflow-hidden shadow-sm focus-within:shadow-md transition-shadow duration-200 max-w-md">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search posts..."
                        class="w-full px-4 py-3 bg-transparent placeholder-gray-500 focus:outline-none text-gray-900 dark:text-gray-100" />
                    <button type="submit"
                        class="px-4 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-r-full transition-colors duration-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </button>
                </form>

                <form method="GET" action="{{ route('public.posts.index') }}" class="flex items-center">
                    <label for="sort" class="mr-2 text-sm font-medium text-gray-700 dark:text-gray-300">Sort by:</label>
                    <select name="sort" id="sort" onchange="this.form.submit()"
                        class="px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest</option>
                        <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Oldest</option>
                        <option value="most_viewed" {{ request('sort') == 'most_viewed' ? 'selected' : '' }}>Most Viewed</option>
                        <option value="title_asc" {{ request('sort') == 'title_asc' ? 'selected' : '' }}>Title A-Z</option>
                        <option value="title_desc" {{ request('sort') == 'title_desc' ? 'selected' : '' }}>Title Z-A</option>
                    </select>
                    {{-- Preserve other params --}}
                    @if(request('category'))
                        <input type="hidden" name="category" value="{{ request('category') }}">
                    @endif
                    @if(request('search'))
                        <input type="hidden" name="search" value="{{ request('search') }}">
                    @endif
                </form>
            </div>

            {{-- Posts Grid --}}
            @if($posts->count() > 0)
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($posts as $post)
                        <article
                            class="bg-white dark:bg-gray-800 rounded-xl overflow-hidden shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300">
                            {{-- Post Image --}}
                            @if($post->image)
                                <div class="h-48 bg-cover bg-center" 
                                    style="background-image: url('{{ asset('storage/' . $post->image) }}')"></div>
                            @else
                                <div class="h-48 bg-gray-300 dark:bg-gray-700 flex items-center justify-center">
                                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                            @endif
                            
                            <div class="p-6">
                                <div class="text-xs text-gray-500 dark:text-gray-400 mb-2 flex items-center gap-2 flex-wrap">
                                    <span>{{ $post->user->name ?? 'Staff' }}</span>
                                    <span>•</span>
                                    <span>{{ $post->created_at->format('M d, Y') }}</span>
                                    {{-- View Count --}}
                                    <span>•</span>
                                    <span class="flex items-center gap-1">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                        {{ $post->formatted_views }}
                                    </span>
                                    @if($post->category)
                                        <span>•</span>
                                        <span class="bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 px-2 py-0.5 rounded-full">
                                            {{ $post->category->name }}
                                        </span>
                                    @endif
                                </div>
                                
                                <h4 class="font-semibold text-xl text-gray-900 dark:text-white mb-3 leading-tight">
                                    <a href="{{ route('public.posts.show', $post) }}"
                                        class="hover:text-blue-600 dark:hover:text-blue-400 transition-colors duration-200">
                                        {{ $post->title }}
                                    </a>
                                </h4>
                                
                                <p class="text-sm text-gray-700 dark:text-gray-300 line-clamp-3 leading-relaxed mb-4">
                                    {{ Str::limit(strip_tags($post->content), 120) }}
                                </p>
                                
                                {{-- Post Tags --}}
                                @if($post->tags->isNotEmpty())
                                    <div class="flex flex-wrap gap-1 mb-3">
                                        @foreach($post->tags->take(3) as $tag)
                                            <a href="{{ route('public.posts.index', ['tag' => $tag->slug]) }}"
                                                class="bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-400 px-2 py-0.5 rounded-full text-xs hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors duration-200">
                                                #{{ $tag->name }}
                                            </a>
                                        @endforeach
                                    </div>
                                @endif
                                
                                <div class="flex items-center justify-between">
                                    <a href="{{ route('public.posts.show', $post) }}"
                                        class="text-blue-600 dark:text-blue-400 hover:underline font-medium text-sm">
                                        Read More →
                                    </a>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>

                {{-- Pagination --}}
                <div class="mt-12">
                    @if(method_exists($posts, 'links'))
                        <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-lg">
                            {{ $posts->links() }}
                        </div>
                    @endif
                </div>
            @else
                <div class="text-center py-12">
                    <p class="text-gray-500 dark:text-gray-400 text-lg">
                        No published posts available
                        @if(request('category') || request('search'))
                            matching your criteria.
                        @endif
                        <a href="{{ route('public.posts.index') }}" class="text-blue-600 hover:underline">View all posts</a>.
                    </p>
                </div>
            @endif
        </div>
    </div>
</x-blog-header>
<x-footer />