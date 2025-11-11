<div>
    @php 
        $posts = $posts ?? collect(); 
        $featuredPosts = $featuredPosts ?? collect(); 
    @endphp

    {{-- Hero Section with Search & Filters --}}
    <div class="bg-linear-to-br from-blue-50 via-white to-purple-50 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900 border-b border-gray-200 dark:border-gray-700">
        <div class="max-w-7xl mx-auto px-6 py-12">
            {{-- Hero Text --}}
            <div class="text-center mb-8">
                <h1 class="text-4xl md:text-5xl font-extrabold text-gray-900 dark:text-white mb-4 tracking-tight">
                    Welcome to <span class="bg-linear-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">The Brief</span>
                </h1>
                <p class="text-lg text-gray-600 dark:text-gray-400 max-w-2xl mx-auto">
                    Discover the latest news, insights, and stories that matter most
                </p>
            </div>

            {{-- Search Bar --}}
            <div class="relative max-w-2xl mx-auto mb-8">
                <div class="flex items-center bg-white dark:bg-gray-800 border-2 border-gray-200 dark:border-gray-700 rounded-2xl overflow-hidden shadow-lg hover:shadow-xl transition-shadow duration-300">
                        <svg class="w-6 h-6 text-gray-400 ml-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        <input
                            wire:model.live.debounce.500ms="search"
                            type="search"
                            placeholder="Search for articles, topics, or authors..."
                            class="w-full px-4 py-4 bg-transparent placeholder-gray-500 focus:outline-none text-gray-900 dark:text-gray-100 text-base"
                            aria-label="Search articles"
                        />
                        @if($search)
                            <button wire:click="$set('search', '')" class="px-4 py-4 text-gray-600 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        @endif
                </div>
            </div>

            {{-- Category Pills --}}
            <div class="flex items-center justify-center gap-3 flex-wrap">
                <button 
                    wire:click="$set('category', null)" 
                    class="px-5 py-2.5 rounded-full text-sm font-semibold transition-all duration-300 {{ !$category ? 'bg-blue-600 text-white shadow-lg scale-105' : 'bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 shadow-md' }}">
                    All Stories
                </button>
                @foreach($categories as $cat)
                    <button 
                        wire:click="$set('category', '{{ $cat->slug }}')" 
                        class="px-5 py-2.5 rounded-full text-sm font-semibold transition-all duration-300 {{ $category === $cat->slug ? 'bg-blue-600 text-white shadow-lg scale-105' : 'bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 shadow-md' }}">
                        {{ $cat->name }}
                    </button>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Main Content Area --}}
    <div class="bg-gray-50 dark:bg-gray-900 min-h-screen">
        <div class="max-w-7xl mx-auto px-6 py-12">
            
            {{-- Featured Articles Carousel --}}
            @if($featuredPosts->isNotEmpty())
                <section class="mb-16" 
                         wire:poll.10000ms="nextSlide({{ $featuredPosts->count() }})"
                         wire:mouseenter="$set('isPaused', true)"
                         wire:mouseleave="$set('isPaused', false)">
                    
                    <div class="flex items-center justify-between mb-6">
                        <div class="flex items-center gap-2">
                            <div class="w-1 h-8 bg-linear-to-b from-blue-600 to-purple-600 rounded-full"></div>
                                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Featured Stories</h2>
                            </div>
    
                        {{-- Slide Counter --}}
                        <div class="flex items-center gap-3">
                            <span class="text-sm text-gray-600 dark:text-gray-400 font-medium">
                                {{ $currentSlide + 1 }} / {{ $featuredPosts->count() }}
                            </span>
                        </div>
                    </div>

                    {{-- Carousel Container --}}
                    <div class="relative overflow-hidden rounded-3xl shadow-2xl">
                        <div class="flex transition-transform duration-700 ease-in-out" 
                            style="transform: translateX(-{{ $currentSlide * 100 }}%);">
                            
                            @foreach($featuredPosts as $index => $featured)
                                <article class="min-w-full group relative bg-white dark:bg-gray-800 overflow-hidden">
                                    <div class="grid lg:grid-cols-5 gap-0">
                                        {{-- Featured Image (60% width) --}}
                                        <div class="relative overflow-hidden lg:col-span-3 h-96 lg:h-[600px]">
                                            @if($featured->image)
                                                <img src="{{ asset('storage/' . $featured->image) }}" 
                                                    alt="{{ $featured->title }}"
                                                    loading="{{ $index === $currentSlide ? 'eager' : 'lazy' }}"
                                                    class="w-full h-full object-cover">
                                            @else
                                                <div class="w-full h-full bg-linear-to-br from-blue-100 to-purple-100 dark:from-gray-700 dark:to-gray-800 flex items-center justify-center">
                                                    <svg class="w-24 h-24 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                    </svg>
                                                </div>
                                            @endif
                                            
                                            {{-- Gradient Overlay --}}
                                            <div class="absolute inset-0 bg-linear-to-t from-black/60 via-black/20 to-transparent lg:hidden"></div>
                                            
                                            {{-- Featured Badge --}}
                                            <div class="absolute top-6 left-6">
                                                <div class="flex items-center gap-2 bg-linear-to-r from-red-600 to-pink-600 text-white px-4 py-2 rounded-full shadow-2xl backdrop-blur-sm">
                                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                                    </svg>
                                                    <span class="text-xs font-bold tracking-wider">FEATURED</span>
                                                </div>
                                            </div>

                                            {{-- Mobile Title Overlay --}}
                                            <div class="lg:hidden absolute bottom-6 left-6 right-6">
                                                <h3 class="text-2xl font-bold text-white mb-2 line-clamp-2 drop-shadow-lg">
                                                    {{ $featured->title }}
                                                </h3>
                                            </div>
                                        </div>

                                        {{-- Featured Content (40% width) --}}
                                        <div class="p-8 lg:p-10 flex flex-col justify-center lg:col-span-2 bg-white dark:bg-gray-800">
                                            {{-- Meta Info --}}
                                            <div class="flex items-center flex-wrap gap-2 text-sm mb-4">
                                                @if($featured->category)
                                                    <span class="bg-linear-to-r from-blue-600 to-purple-600 text-white px-3 py-1.5 rounded-lg font-semibold shadow-md">
                                                        {{ $featured->category->name }}
                                                    </span>
                                                @endif
                                                <span class="text-gray-400">•</span>
                                                <time class="text-gray-600 dark:text-gray-400">
                                                    {{ $featured->created_at->format('M d, Y') }}
                                                </time>
                                                <span class="text-gray-400">•</span>
                                                <span class="flex items-center gap-1 text-gray-600 dark:text-gray-400">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                    </svg>
                                                    {{ $featured->formatted_views }}
                                                </span>
                                            </div>

                                            {{-- Title (Desktop only) --}}
                                            <h3 class="hidden lg:block text-3xl xl:text-4xl font-bold text-gray-900 dark:text-white mb-4 leading-tight line-clamp-3">
                                                {{ $featured->title }}
                                            </h3>

                                            {{-- Excerpt --}}
                                            <p class="text-gray-700 dark:text-gray-300 mb-6 line-clamp-3 leading-relaxed">
                                                {!! \Illuminate\Support\Str::limit(strip_tags($featured->content), 180) !!}
                                            </p>

                                            {{-- Tags --}}
                                            @if($featured->tags->count() > 0)
                                                <div class="flex flex-wrap gap-2 mb-6">
                                                    @foreach($featured->tags->take(3) as $tag)
                                                        @if($tag->slug !== 'featured')
                                                            <span class="bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 px-3 py-1 rounded-full text-xs font-medium">
                                                                #{{ $tag->name }}
                                                            </span>
                                                        @endif
                                                    @endforeach
                                                </div>
                                            @endif

                                            {{-- Action Buttons --}}
                                            <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4">
                                                <a href="{{ route('public.posts.show', $featured) }}" 
                                                class="inline-flex items-center gap-2 bg-linear-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white px-6 py-3 rounded-xl font-semibold shadow-lg hover:shadow-xl transition-all duration-300 group">
                                                    Read Full Story
                                                    <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                                                    </svg>
                                                </a>
                                                <div class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400">
                                                    <div class="w-8 h-8 bg-linear-to-br from-blue-500 to-purple-500 rounded-full flex items-center justify-center text-white font-semibold">
                                                        {{ substr($featured->user->name ?? 'S', 0, 1) }}
                                                    </div>
                                                    <span class="font-medium text-gray-900 dark:text-white">{{ $featured->user->name ?? 'Staff' }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </article>
                            @endforeach
                        </div>

                        {{-- Navigation Dots --}}
                        <div class="absolute bottom-6 left-1/2 transform -translate-x-1/2 flex gap-2 z-20">
                            @foreach($featuredPosts as $index => $featured)
                                <button 
                                    wire:click="goToSlide({{ $index }})"
                                    class="group relative transition-all duration-300 hover:scale-110"
                                    aria-label="Go to slide {{ $index + 1 }}">
                                    <span class="block w-2.5 h-2.5 rounded-full transition-all duration-300 {{ $currentSlide === $index ? 'bg-white scale-125 shadow-lg' : 'bg-white/50 hover:bg-white/75' }}"></span>
                                </button>
                            @endforeach
                        </div>
                    </div>
                </section>
            @endif

            {{-- Latest Stories Grid --}}
            <section>
                <div class="flex items-center justify-between mb-8">
                    <div class="flex items-center gap-2">
                        <div class="w-1 h-8 bg-linear-to-b from-blue-600 to-purple-600 rounded-full"></div>
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Latest Stories</h2>
                    </div>
                </div>

                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @forelse($posts as $post)
                        <article class="group bg-white dark:bg-gray-800 rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-500 hover:-translate-y-2">
                            {{-- Image --}}
                            <div class="relative overflow-hidden h-52">
                                @if($post->image)
                                    <img src="{{ asset('storage/' . $post->image) }}" 
                                         alt="{{ $post->title }}"
                                         loading="lazy"
                                         decoding="async"
                                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                                @else
                                    <div class="w-full h-full bg-linear-to-br from-gray-200 to-gray-300 dark:from-gray-700 dark:to-gray-800 flex items-center justify-center">
                                        <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                @endif
                                
                                {{-- Category Badge --}}
                                @if($post->category)
                                    <div class="absolute top-4 left-4">
                                        <span class="bg-blue-600 text-white px-3 py-1 rounded-full text-xs font-semibold shadow-lg">
                                            {{ $post->category->name }}
                                        </span>
                                    </div>
                                @endif
                            </div>

                            {{-- Content --}}
                            <div class="p-6">
                                {{-- Meta --}}
                                <div class="flex items-center gap-2 text-xs text-gray-600 dark:text-gray-400 mb-3">
                                    <span>{{ $post->created_at->format('M d, Y') }}</span>
                                    <span>•</span>
                                    <span class="flex items-center gap-1">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                        {{ $post->formatted_views }}
                                    </span>
                                </div>

                                {{-- Title --}}
                                <h4 class="font-bold text-xl text-gray-900 dark:text-white mb-3 leading-tight line-clamp-2 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">
                                    <a href="{{ route('public.posts.show', $post) }}">
                                        {{ $post->title }}
                                    </a>
                                </h4>

                                {{-- Excerpt --}}
                                <p class="text-gray-700 dark:text-gray-300 text-sm mb-4 line-clamp-3 leading-relaxed">
                                    {!! \Illuminate\Support\Str::limit(strip_tags($post->content), 120) !!}
                                </p>

                                {{-- Footer --}}
                                <div class="flex items-center justify-between pt-4 border-t border-gray-200 dark:border-gray-700">
                                    <a href="{{ route('public.posts.show', $post) }}" 
                                       class="inline-flex items-center gap-1 text-blue-600 dark:text-blue-400 hover:gap-2 font-semibold text-sm transition-all">
                                        Read More
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                                        </svg>
                                    </a>
                                    <span class="text-xs text-gray-600 dark:text-gray-400">
                                        {{ $post->user->name ?? 'Staff' }}
                                    </span>
                                </div>
                            </div>
                        </article>
                    @empty
                        <div class="md:col-span-2 lg:col-span-3 bg-white dark:bg-gray-800 p-12 rounded-2xl shadow-lg text-center">
                            <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">No Articles Yet</h3>
                            <p class="text-gray-600 dark:text-gray-400">Check back soon for the latest stories.</p>
                        </div>
                    @endforelse
                </div>

                {{-- View More Button --}}
                @if($hasMore ?? false)
                    <div class="mt-12 text-center">
                        
                            <a href="{{ route('public.posts.index') }}" 
                               class="inline-flex items-center gap-3 bg-linear-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white px-8 py-4 rounded-xl font-bold text-lg shadow-lg hover:shadow-xl transition-all duration-300 group">
                                Explore All Stories
                                <svg class="w-6 h-6 group-hover:translate-x-2 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                </svg>
                            </a>
                           
                    </div>
                @endif
            </section>

            {{-- Sidebar Content (Newsletter & Tags) --}}
            <aside class="mt-16 grid md:grid-cols-2 gap-8">
                {{-- Newsletter Card --}}
                <div class="bg-linear-to-br from-blue-600 to-purple-600 rounded-2xl p-8 shadow-2xl text-white">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-12 h-12 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold">Stay Updated</h3>
                    </div>
                    <p class="mb-6 text-blue-100">Subscribe to get the latest stories delivered to your inbox.</p>

                    @if(session('newsletter_success'))
                        <div class="mb-4 p-4 bg-green-500/30 backdrop-blur-sm border border-green-300 rounded-xl">
                            <p class="text-sm text-white">{{ session('newsletter_success') }}</p>
                        </div>
                    @endif

                    @if(session('newsletter_error'))
                        <div class="mb-4 p-4 bg-red-500/30 backdrop-blur-sm border border-red-300 rounded-xl">
                            <p class="text-sm text-white">{{ session('newsletter_error') }}</p>
                        </div>
                    @endif

                    <form action="{{ route('newsletter.subscribe') }}" method="POST" class="space-y-4">
                        @csrf
                        <input 
                            type="email" 
                            name="email" 
                            placeholder="Enter your email" 
                            required 
                            class="w-full px-4 py-3 rounded-xl bg-white/20 backdrop-blur-sm text-white placeholder-white/70 border border-white/30 focus:outline-none focus:ring-2 focus:ring-white/50 @error('email') @enderror" />
                        @error('email')
                            <p class="text-xs text-red-200">{{ $message }}</p>
                        @enderror
                        <button type="submit" 
                                class="w-full bg-white text-blue-600 py-3 rounded-xl font-bold hover:bg-blue-50 transition-all duration-300 shadow-lg hover:shadow-xl">
                            Subscribe Now
                        </button>
                    </form>
                </div>

                {{-- Popular Tags Card --}}
                <div class="bg-white dark:bg-gray-800 rounded-2xl p-8 shadow-lg">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-12 h-12 bg-linear-to-br from-blue-500 to-purple-500 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-white">Popular Tags</h3>
                    </div>
                    
                    <div class="flex flex-wrap gap-2">
                        @forelse($popularTags as $tag)
                            <a href="{{ route('public.posts.index', ['tag' => $tag->slug]) }}" 
                               class="inline-flex items-center gap-1 px-4 py-2 bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200 rounded-full text-sm font-medium hover:bg-blue-100 dark:hover:bg-blue-900 hover:text-blue-600 dark:hover:text-blue-300 transition-all duration-300 hover:shadow-md">
                                #{{ $tag->name }}
                                <span class="text-xs text-gray-500 dark:text-gray-400">({{ $tag->posts_count }})</span>
                            </a>
                        @empty
                            <p class="text-sm text-gray-500 dark:text-gray-400">No tags yet</p>
                        @endforelse
                    </div>
                </div>
            </aside>

        </div>
    </div>

    
</div>