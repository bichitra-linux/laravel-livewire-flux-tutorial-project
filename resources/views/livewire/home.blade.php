<div> {{-- SINGLE ROOT for Livewire component --}}
    @php $posts = $posts ?? collect(); @endphp

    {{-- Categories filter (Livewire-bound) --}}
    <div class="max-w-7xl mx-auto px-6 pb-6">
        <div class="flex items-center gap-2 overflow-x-auto scrollbar-hide">
            <button wire:click="$set('category', null)" class="px-4 py-2 rounded-full text-sm font-medium transition-all duration-200 {{ !$category ? 'bg-blue-600 text-white shadow-md' : 'bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600' }}">
                All
            </button>
            @foreach($categories ?? [] as $cat)
                <button wire:click="$set('category', '{{ $cat->slug }}')" class="px-4 py-2 rounded-full text-sm font-medium transition-all duration-200 {{ $category === $cat->slug ? 'bg-blue-600 text-white shadow-md' : 'bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600' }}">
                    {{ $cat->name }}
                </button>
            @endforeach
        </div>
    </div>

    {{-- Search (Livewire-bound) --}}
    <div class="max-w-7xl mx-auto px-6 pb-6">
        <div class="relative max-w-md mx-auto lg:mx-0">
            <div class="flex items-center bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-full overflow-hidden shadow-sm focus-within:shadow-md transition-shadow duration-200">
                <svg class="w-5 h-5 text-gray-400 ml-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
                <input
                    wire:model.debounce.500ms="search"
                    type="search"
                    placeholder="Search articles, topics, authors..."
                    class="w-full px-4 py-3 bg-transparent placeholder-gray-500 focus:outline-none text-gray-900 dark:text-gray-100"
                    aria-label="Search articles"
                />
                @if($search)
                    <button wire:click="$set('search', '')" class="px-4 py-3 text-sm text-gray-600 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200 transition-colors duration-200">
                        Clear
                    </button>
                @endif
            </div>
        </div>
    </div>

    <div class="min-h-screen bg-gray-50 dark:bg-gray-900">
        <div class="max-w-7xl mx-auto px-6 py-6">

            {{-- Top hero + featured article --}}
            <div class="grid lg:grid-cols-12 gap-8 mb-12">
                <div class="lg:col-span-8">
                    @if($posts->isNotEmpty())
                        @php $featured = $posts->first(); @endphp
                        <article class="relative rounded-xl overflow-hidden shadow-xl bg-gradient-to-r from-white to-gray-100 dark:from-gray-800 dark:to-gray-700 transform hover:scale-105 transition-transform duration-300">
                            <div class="lg:flex">
                                <div class="lg:w-1/2 bg-cover bg-center min-h-[300px] lg:min-h-[400px]" style="background-image: url('{{ $featured->image ?? asset('images/placeholder.jpg') }}');"></div>
                                <div class="p-8 lg:w-1/2 flex flex-col justify-center">
                                    <div class="flex items-center gap-3 text-sm text-gray-500 dark:text-gray-400 mb-4">
                                        <span>{{ optional($featured->user)->name ?? 'Staff' }}</span>
                                        <span>•</span>
                                        <span>{{ optional($featured->created_at)->diffForHumans() }}</span>
                                    </div>
                                    <h2 class="text-3xl lg:text-4xl font-extrabold text-gray-900 dark:text-white mb-4 leading-tight">
                                        <a href="{{ route('public.posts.show', $featured) }}" class="hover:text-blue-600 dark:hover:text-blue-400 transition-colors duration-200">{{ $featured->title }}</a>
                                    </h2>
                                    <p class="text-gray-700 dark:text-gray-300 mb-6 line-clamp-4 text-lg leading-relaxed">{!! \Illuminate\Support\Str::limit(strip_tags($featured->content), 250) !!}</p>
                                    <div class="flex items-center gap-4">
                                        <a href="{{ route('public.posts.show', $featured) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-full font-semibold shadow-md transition-all duration-200">Read More</a>
                                        <a href="{{ route('public.posts.index') }}" class="text-blue-600 dark:text-blue-400 hover:underline font-medium">View All Posts</a>
                                    </div>
                                </div>
                            </div>
                        </article>
                    @else
                        <div class="rounded-xl p-8 bg-white dark:bg-gray-800 shadow-lg">
                            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">No featured article yet</h2>
                            <p class="text-gray-600 dark:text-gray-300 mt-2">Check back soon for the latest stories.</p>
                        </div>
                    @endif
                </div>

                {{-- Right column / quick links --}}
                <aside class="lg:col-span-4 space-y-6">
                    <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-lg">
                        <h3 class="font-bold text-lg text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                            <svg class="w-5 h-5 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                            </svg>
                            Trending
                        </h3>
                        <ul class="space-y-3 text-sm text-gray-700 dark:text-gray-300">
                            @forelse($posts->take(5) as $p)
                                <li>
                                    <a href="{{ route('public.posts.show', $p) }}" class="hover:text-blue-600 dark:hover:text-blue-400 transition-colors duration-200 block">
                                        <div class="flex items-start gap-3">
                                            <div class="flex-1">
                                                <div class="font-medium">{{ $p->title }}</div>
                                                <div class="text-xs text-gray-500 dark:text-gray-400">{{ optional($p->created_at)->diffForHumans() }}</div>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                            @empty
                                <li class="text-gray-500 dark:text-gray-400">No trending posts.</li>
                            @endforelse
                        </ul>
                    </div>

                    <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-lg">
                        <h3 class="font-bold text-lg text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                            <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                            </svg>
                            Topics
                        </h3>
                        <div class="flex flex-wrap gap-2">
                            <a href="#" class="text-xs px-3 py-1 bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 rounded-full hover:bg-blue-200 dark:hover:bg-blue-800 transition-colors duration-200">World</a>
                            <a href="#" class="text-xs px-3 py-1 bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200 rounded-full hover:bg-green-200 dark:hover:bg-green-800 transition-colors duration-200">Technology</a>
                            <a href="#" class="text-xs px-3 py-1 bg-purple-100 dark:bg-purple-900 text-purple-800 dark:text-purple-200 rounded-full hover:bg-purple-200 dark:hover:bg-purple-800 transition-colors duration-200">Business</a>
                            <a href="#" class="text-xs px-3 py-1 bg-pink-100 dark:bg-pink-900 text-pink-800 dark:text-pink-200 rounded-full hover:bg-pink-200 dark:hover:bg-pink-800 transition-colors duration-200">Lifestyle</a>
                            <a href="#" class="text-xs px-3 py-1 bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-200 rounded-full hover:bg-yellow-200 dark:hover:bg-yellow-800 transition-colors duration-200">Culture</a>
                        </div>
                    </div>

                    <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-lg">
                        <h3 class="font-bold text-lg text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                            <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                            Subscribe
                        </h3>
                        <form action="#" method="POST" class="space-y-4">
                            <input type="email" name="email" placeholder="Your email" required class="w-full px-3 py-2 rounded-lg bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-gray-100 border border-gray-300 dark:border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all duration-200" />
                            <button type="submit" class="w-full bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white py-3 rounded-lg font-semibold shadow-md transition-all duration-200">Subscribe</button>
                        </form>
                    </div>
                </aside>
            </div>

            {{-- Articles grid --}}
            <section class="mt-12">
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @if($posts->isNotEmpty())
                        @foreach($posts->skip(1) as $post)
                            <article class="bg-white dark:bg-gray-800 rounded-xl overflow-hidden shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300">
                                <div class="h-48 bg-cover bg-center" style="background-image: url('{{ $post->image ?? asset('images/placeholder.jpg') }}')"></div>
                                <div class="p-6">
                                    <div class="text-xs text-gray-500 dark:text-gray-400 mb-2">{{ optional($post->created_at)->format('M d, Y') }} • {{ optional($post->user)->name ?? 'Staff' }}</div>
                                    <h4 class="font-semibold text-xl text-gray-900 dark:text-white mb-3 leading-tight">
                                        <a href="{{ route('public.posts.show', $post) }}" class="hover:text-blue-600 dark:hover:text-blue-400 transition-colors duration-200">{{ $post->title }}</a>
                                    </h4>
                                    <p class="text-sm text-gray-700 dark:text-gray-300 line-clamp-3 leading-relaxed">{!! \Illuminate\Support\Str::limit(strip_tags($post->content), 120) !!}</p>
                                    <div class="mt-3">
                                        <span class="inline-block px-2 py-1 text-xs font-medium rounded-full bg-{{ $post->status->color() }}-100 text-{{ $post->status->color() }}-800 dark:bg-{{ $post->status->color() }}-900 dark:text-{{ $post->status->color() }}-200">
                                            {{ $post->status->label() }}
                                        </span>
                                    </div>
                                </div>
                            </article>
                        @endforeach
                    @else
                        <div class="md:col-span-2 lg:col-span-3 bg-white dark:bg-gray-800 p-8 rounded-xl shadow-lg text-center">
                            <p class="text-gray-600 dark:text-gray-300 text-lg">There are no articles to display yet.</p>
                        </div>
                    @endif
                </div>

                {{-- Pagination --}}
                <div class="mt-12">
                    @if(method_exists($posts, 'links'))
                        <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-lg">
                            {{ $posts->links() }}
                        </div>
                    @endif
                </div>
            </section>
        </div>
    </div>
</div>