<div> {{-- SINGLE ROOT for Livewire component --}}
    @php $posts = $posts ?? collect(); @endphp


    {{-- Categories filter (Livewire-bound) --}}
    <div class="max-w-7xl mx-auto px-6 pb-4">
        <div class="flex items-center gap-3 overflow-x-auto">
            <button wire:click="$set('category', null)" class="px-3 py-1 rounded {{ !$category ? 'bg-blue-600 text-white' : 'bg-gray-100 dark:bg-gray-700' }}">All</button>
            @foreach($categories ?? [] as $cat)
                <button wire:click="$set('category', '{{ $cat->slug }}')" class="px-3 py-1 rounded {{ $category === $cat->slug ? 'bg-blue-600 text-white' : 'bg-gray-100 dark:bg-gray-700' }}">
                    {{ $cat->name }}
                </button>
            @endforeach
        </div>
    </div>

    {{-- Search (Livewire-bound) --}}
    <div class="max-w-7xl mx-auto px-6 pb-4">
        <div class="max-w-7xl mx-auto">
            <div class="flex items-center bg-gray-100 dark:bg-gray-800 rounded-lg overflow-hidden">
                <input
                    wire:model.debounce.500ms="search"
                    type="search"
                    placeholder="Search articles, topics, authors..."
                    class="w-full px-4 py-3 bg-transparent placeholder-gray-500 focus:outline-none text-gray-900 dark:text-gray-100"
                    aria-label="Search articles"
                />
                <button wire:click="$set('search', '')" class="px-4 py-3 text-sm text-gray-600 dark:text-gray-200 hover:underline">Clear</button>
            </div>
        </div>
    </div>

    <div class="min-h-screen">
        <div class="max-w-7xl mx-auto px-6 py-6">

            {{-- Top hero + featured article --}}
            <div class="grid md:grid-cols-12 gap-8">
                <div class="md:col-span-8">
                    @if($posts->isNotEmpty())
                        @php $featured = $posts->first(); @endphp
                        <article class="relative rounded-lg overflow-hidden shadow-lg bg-white dark:bg-gray-800">
                            <div class="md:flex">
                                <div class="md:w-1/2 bg-cover bg-center" style="background-image: url('{{ $featured->image ?? asset('images/placeholder.jpg') }}'); min-height: 300px;"></div>
                                <div class="p-8 md:w-1/2">
                                    <div class="flex items-center gap-3 text-sm text-gray-500 mb-3">
                                        <span>{{ optional($featured->user)->name ?? 'Staff' }}</span>
                                        <span>•</span>
                                        <span>{{ optional($featured->created_at)->diffForHumans() }}</span>
                                    </div>
                                    <h2 class="text-2xl md:text-3xl font-extrabold text-gray-900 dark:text-white mb-4">
                                        <a href="{{ route('posts.show', $featured) }}" class="hover:underline">{{ $featured->title }}</a>
                                    </h2>
                                    <p class="text-gray-700 dark:text-gray-300 mb-6 line-clamp-4">{!! \Illuminate\Support\Str::limit(strip_tags($featured->content), 250) !!}</p>
                                    <div class="flex items-center gap-4">
                                        <a href="{{ route('posts.show', $featured) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">Read More</a>
                                        <a href="{{ route('posts.index') }}" class="text-gray-600 dark:text-gray-300 hover:underline">View All Posts</a>
                                    </div>
                                </div>
                            </div>
                        </article>
                    @else
                        <div class="rounded-lg p-8 bg-white dark:bg-gray-800 shadow">
                            <h2 class="text-xl font-bold text-gray-900 dark:text-white">No featured article yet</h2>
                            <p class="text-gray-600 dark:text-gray-300 mt-2">Check back soon for the latest stories.</p>
                        </div>
                    @endif
                </div>

                {{-- Right column / quick links --}}
                <aside class="md:col-span-4 space-y-6">
                    <div class="bg-white dark:bg-gray-800 rounded-lg p-6 shadow">
                        <h3 class="font-bold text-lg text-gray-900 dark:text-white mb-3">Trending</h3>
                        <ul class="space-y-3 text-sm text-gray-700 dark:text-gray-300">
                            @forelse($posts->take(5) as $p)
                                <li>
                                    <a href="{{ route('posts.show', $p) }}" class="hover:underline">
                                        <div class="flex items-start gap-3">
                                            <div class="flex-1">
                                                <div class="font-medium">{{ $p->title }}</div>
                                                <div class="text-xs text-gray-500">{{ optional($p->created_at)->diffForHumans() }}</div>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                            @empty
                                <li class="text-gray-500">No trending posts.</li>
                            @endforelse
                        </ul>
                    </div>

                    <div class="bg-white dark:bg-gray-800 rounded-lg p-6 shadow">
                        <h3 class="font-bold text-lg text-gray-900 dark:text-white mb-3">Topics</h3>
                        <div class="flex flex-wrap gap-2">
                            <a href="#" class="text-xs px-3 py-1 bg-gray-100 dark:bg-gray-700 rounded-full hover:bg-gray-200">World</a>
                            <a href="#" class="text-xs px-3 py-1 bg-gray-100 dark:bg-gray-700 rounded-full hover:bg-gray-200">Technology</a>
                            <a href="#" class="text-xs px-3 py-1 bg-gray-100 dark:bg-gray-700 rounded-full hover:bg-gray-200">Business</a>
                            <a href="#" class="text-xs px-3 py-1 bg-gray-100 dark:bg-gray-700 rounded-full hover:bg-gray-200">Lifestyle</a>
                            <a href="#" class="text-xs px-3 py-1 bg-gray-100 dark:bg-gray-700 rounded-full hover:bg-gray-200">Culture</a>
                        </div>
                    </div>

                    <div class="bg-white dark:bg-gray-800 rounded-lg p-6 shadow">
                        <h3 class="font-bold text-lg text-gray-900 dark:text-white mb-3">Subscribe</h3>
                        <form action="#" method="POST" class="space-y-3">
                            <input type="email" name="email" placeholder="Your email" required class="w-full px-3 py-2 rounded bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-gray-100" />
                            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 rounded">Subscribe</button>
                        </form>
                    </div>
                </aside>
            </div>

            {{-- Articles grid --}}
            <section class="mt-12">
                <div class="grid md:grid-cols-3 gap-8">
                    @if($posts->isNotEmpty())
                        @foreach($posts->skip(1) as $post)
                            <article class="bg-white dark:bg-gray-800 rounded-lg overflow-hidden shadow">
                                <div class="h-40 bg-cover bg-center" style="background-image: url('{{ $post->image ?? asset('images/placeholder.jpg') }}')"></div>
                                <div class="p-4">
                                    <div class="text-xs text-gray-500 mb-2">{{ optional($post->created_at)->format('M d, Y') }} • {{ optional($post->user)->name ?? 'Staff' }}</div>
                                    <h4 class="font-semibold text-lg text-gray-900 dark:text-white mb-2">
                                        <a href="{{ route('posts.show', $post) }}" class="hover:underline">{{ $post->title }}</a>
                                    </h4>
                                    <p class="text-sm text-gray-700 dark:text-gray-300 line-clamp-3">{!! \Illuminate\Support\Str::limit(strip_tags($post->content), 120) !!}</p>
                                </div>
                            </article>
                        @endforeach
                    @else
                        <div class="md:col-span-3 bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
                            <p class="text-gray-600 dark:text-gray-300">There are no articles to display yet.</p>
                        </div>
                    @endif
                </div>

                {{-- Pagination --}}
                <div class="mt-8">
                    @if(method_exists($posts, 'links'))
                        <div class="bg-white dark:bg-gray-800 p-4 rounded shadow">
                            {{ $posts->links() }}
                        </div>
                    @endif
                </div>
            </section>
        </div>
    </div>
</div>