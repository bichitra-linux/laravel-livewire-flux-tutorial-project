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
                <a href="{{ route('public.posts.index') }}" class="px-4 py-2 rounded-full text-sm font-medium transition-all duration-200 {{ !request('category') ? 'bg-blue-600 text-white shadow-md' : 'bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600' }}">
                    All
                </a>
                @foreach($categories as $cat)
                    <a href="{{ route('public.posts.index', ['category' => $cat->slug]) }}" class="px-4 py-2 rounded-full text-sm font-medium transition-all duration-200 {{ request('category') === $cat->slug ? 'bg-blue-600 text-white shadow-md' : 'bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600' }}">
                        {{ $cat->name }}
                    </a>
                @endforeach
            </div>

            {{-- Optional Search Bar --}}
            <div class="mb-8 max-w-md mx-auto">
                <form method="GET" action="{{ route('public.posts.index') }}" class="flex items-center bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-full overflow-hidden shadow-sm focus-within:shadow-md transition-shadow duration-200">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search posts..." class="w-full px-4 py-3 bg-transparent placeholder-gray-500 focus:outline-none text-gray-900 dark:text-gray-100" />
                    <button type="submit" class="px-4 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-r-full transition-colors duration-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </button>
                </form>
            </div>

            {{-- Posts Grid --}}
            @if($posts->count() > 0)
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($posts as $post)
                        <article class="bg-white dark:bg-gray-800 rounded-xl overflow-hidden shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300">
                            @if($post->image)
                                <div class="h-48 bg-cover bg-center" style="background-image: url('{{ asset($post->image) }}')"></div>
                            @endif
                            <div class="p-6">
                                <div class="text-xs text-gray-500 dark:text-gray-400 mb-2 flex items-center gap-2">
                                    <span>{{ optional($post->user)->name ?? 'Staff' }}</span>
                                    <span>•</span>
                                    <span>{{ optional($post->created_at)->format('M d, Y') }}</span>
                                </div>
                                <h4 class="font-semibold text-xl text-gray-900 dark:text-white mb-3 leading-tight">
                                    <a href="{{ route('public.posts.show', $post) }}" class="hover:text-blue-600 dark:hover:text-blue-400 transition-colors duration-200">{{ $post->title }}</a>
                                </h4>
                                <p class="text-sm text-gray-700 dark:text-gray-300 line-clamp-3 leading-relaxed mb-4">{!! \Illuminate\Support\Str::limit(strip_tags($post->content), 120) !!}</p>
                                <div class="flex items-center justify-between">
                                    @if($post->category)
                                        <span class="inline-block px-3 py-1 text-xs font-medium bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 rounded-full">
                                            {{ $post->category->name }}
                                        </span>
                                    @endif
                                    <a href="{{ route('public.posts.show', $post) }}" class="text-blue-600 dark:text-blue-400 hover:underline font-medium text-sm">Read More</a>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>

                {{-- Pagination --}}
                <div class="mt-12 flex justify-center">
                    {{ $posts->links() }}
                </div>
            @else
                <div class="text-center py-12">
                    <p class="text-gray-500 dark:text-gray-400 text-lg">No published posts available in this category. <a href="{{ route('public.posts.index') }}" class="text-blue-600 hover:underline">View all posts</a>.</p>
                </div>
            @endif
        </div>
    </div>
</x-blog-header>