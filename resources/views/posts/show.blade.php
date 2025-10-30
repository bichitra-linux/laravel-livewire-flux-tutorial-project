<x-blog-header>
    @php
        // Defensive defaults to avoid "undefined variable" errors
        $related = $related ?? collect();
        $popular = $popular ?? \App\Models\Post::where('status', \App\Enums\PostStatus::Published)
            ->latest()
            ->take(5)
            ->get();
    @endphp
    <div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-12">
        <div class="max-w-7xl mx-auto px-6">
            {{-- Hero Section --}}
            <header class="mb-12">
                <div class="text-center mb-8">
                    <h1 class="text-4xl lg:text-5xl font-extrabold text-gray-900 dark:text-white leading-tight mb-4">
                        {{ $post->title }}
                    </h1>

                    <div class="flex items-center justify-center gap-4 text-sm text-gray-600 dark:text-gray-400 mb-4">
                        <span>By <strong>{{ $post->user->name ?? 'Staff' }}</strong></span>
                        <span>•</span>
                        <span>{{ $post->created_at->format('F j, Y') }}</span>
                        @if($post->category)
                            <span>•</span>
                            <span
                                class="bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 px-2 py-1 rounded-full text-xs">
                                {{ $post->category->name }}
                            </span>
                        @endif
                    </div>

                    {{-- Tags Display --}}
                    @if($post->tags->count() > 0)
                        <div class="flex justify-center flex-wrap gap-2 mb-4">
                            @foreach($post->tags as $tag)
                                <span
                                    class="bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 px-3 py-1 rounded-full text-xs font-medium">
                                    #{{ $tag->name }}
                                </span>
                            @endforeach
                        </div>
                    @endif

                    {{-- Social Share Buttons --}}
                    <div class="flex justify-center gap-4">
                        <a href="https://twitter.com/intent/tweet?url={{ url()->current() }}&text={{ $post->title }}"
                            class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-full text-sm font-medium transition-colors duration-200"
                            target="_blank">Share on Twitter</a>
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ url()->current() }}"
                            class="bg-blue-700 hover:bg-blue-800 text-white px-4 py-2 rounded-full text-sm font-medium transition-colors duration-200"
                            target="_blank">Share on Facebook</a>
                        <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ url()->current() }}"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-full text-sm font-medium transition-colors duration-200"
                            target="_blank">Share on LinkedIn</a>
                    </div>
                </div>

                {{-- Featured Image --}}
                @if($post->image)
                    <div class="w-full h-64 lg:h-96 rounded-xl shadow-lg overflow-hidden">
                        <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}"
                            class="w-full h-full object-cover">
                    </div>
                @endif
            </header>

            {{-- Main Content and Sidebar --}}
            <div class="grid lg:grid-cols-12 gap-8">
                {{-- Main Article --}}
                <main class="lg:col-span-8">
                    <article class="bg-white dark:bg-gray-800 rounded-xl p-8 shadow-lg">
                        <div class="prose prose-lg dark:prose-invert max-w-none">
                            {!! $post->content !!}
                        </div>

                        {{-- Tags Section --}}
                        @if($post->tags->count() > 0)
                            <div class="mt-8 pt-8 border-t border-gray-200 dark:border-gray-700">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-3">Tags:</h3>
                                <div class="flex flex-wrap gap-2">
                                    @foreach($post->tags as $tag)
                                        <a href="{{ route('public.posts.index', ['tag' => $tag->slug]) }}"
                                            class="bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 px-3 py-1 rounded-full text-sm font-medium hover:bg-blue-200 dark:hover:bg-blue-800 transition-colors duration-200">
                                            {{ $tag->name }}
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        {{-- Category Section --}}
                        @if($post->category)
                            <div class="mt-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                                <p class="text-sm text-gray-600 dark:text-gray-400">
                                    Filed under:
                                    <a href="{{ route('public.posts.index', ['category' => $post->category->slug]) }}"
                                        class="text-blue-600 hover:underline font-medium">
                                        {{ $post->category->name }}
                                    </a>
                                </p>
                            </div>
                        @endif

                        {{-- Edit/Delete for admins --}}
                        @if(auth()->check())
                            <div class="mt-8 flex gap-4">
                                <a href="{{ route('posts.edit', $post) }}"
                                    class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-semibold transition-colors duration-200">
                                    Edit Post
                                </a>
                                <form action="{{ route('posts.destroy', $post) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded-lg font-semibold transition-colors duration-200"
                                        onclick="return confirm('Are you sure?')">
                                        Delete Post
                                    </button>
                                </form>
                            </div>
                        @endif
                    </article>

                    {{-- Related Posts --}}
                    <section class="mt-12">
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Related Posts</h2>
                        <div class="grid md:grid-cols-2 gap-6">
                            @forelse($related as $rel)
                                <div
                                    class="bg-white dark:bg-gray-800 rounded-lg overflow-hidden shadow-md hover:shadow-lg transition-shadow duration-200">
                                    @if($rel->image)
                                        <img src="{{ asset('storage/' . $rel->image) }}" alt="{{ $rel->title }}"
                                            class="w-full h-32 object-cover">
                                    @endif
                                    <div class="p-4">
                                        <h3 class="font-semibold text-lg text-gray-900 dark:text-white mb-2">
                                            <a href="{{ route('public.posts.show', $rel) }}"
                                                class="hover:text-blue-600 dark:hover:text-blue-400">
                                                {{ $rel->title }}
                                            </a>
                                        </h3>
                                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">
                                            {{ Str::limit(strip_tags($rel->content), 100) }}
                                        </p>

                                        {{-- Tags in Related Posts --}}
                                        @if($rel->tags->count() > 0)
                                            <div class="flex flex-wrap gap-1 mt-2">
                                                @foreach($rel->tags->take(3) as $tag)
                                                    <span
                                                        class="bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-400 px-2 py-0.5 rounded text-xs">
                                                        {{ $tag->name }}
                                                    </span>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @empty
                                <p class="text-gray-600 dark:text-gray-400">No related posts found.</p>
                            @endforelse
                        </div>
                    </section>
                </main>

                {{-- Sidebar --}}
                <aside class="lg:col-span-4 space-y-8">
                    

                    {{-- Post Meta --}}

                    <div class="flex items-center gap-4 text-sm text-gray-600 dark:text-gray-400 mb-6">
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            <span>{{ $post->user->name ?? 'Staff' }}</span>
                        </div>

                        <span>•</span>

                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                </path>
                            </svg>
                            <span>{{ $post->created_at->format('M d, Y') }}</span>
                        </div>

                        <span>•</span>

                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                </path>
                            </svg>
                            <span>{{ number_format($post->views) }} views</span>
                        </div>
                    </div>

                    {{-- Post Reactions --}}

                    <div class="border-t border-b border-gray-200 dark:border-gray-700 py-4 my-6">
                        @auth
                            <x-post-reactions :post="$post" />
                        @else
                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                <a href="{{ route('login') }}" class="text-blue-600 hover:underline">Login</a> to react to this post
                            </p>
                        @endauth
                    </div>

                    {{-- Author Bio --}}
                    <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-lg">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">About the Author</h3>
                        <div class="flex items-center gap-4 mb-4">
                            <div
                                class="w-12 h-12 bg-gray-300 dark:bg-gray-600 rounded-full flex items-center justify-center">
                                <span class="text-xl font-bold text-gray-600 dark:text-gray-300">
                                    {{ substr($post->user->name ?? 'S', 0, 1) }}
                                </span>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-900 dark:text-white">
                                    {{ $post->user->name ?? 'Staff' }}
                                </p>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Writer & Contributor</p>
                            </div>
                        </div>
                        <p class="text-sm text-gray-700 dark:text-gray-300">
                            Passionate about sharing insights on technology and innovation.
                        </p>
                    </div>

                    {{-- Popular Posts --}}
                    <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-lg">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Popular Posts</h3>
                        <ul class="space-y-3">
                            @foreach($popular as $pop)
                                <li>
                                    <a href="{{ route('public.posts.show', $pop) }}"
                                        class="text-gray-900 dark:text-white hover:text-blue-600 dark:hover:text-blue-400 font-medium">
                                        {{ $pop->title }}
                                    </a>
                                    <p class="text-xs text-gray-600 dark:text-gray-400">
                                        {{ $pop->created_at->diffForHumans() }}
                                    </p>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    {{-- Newsletter Signup --}}
                    <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-lg">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Stay Updated</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">
                            Get the latest posts delivered to your inbox.
                        </p>
                        <form action="#" method="POST" class="space-y-3">
                            <input type="email" name="email" placeholder="Your email" required
                                class="w-full px-3 py-2 rounded-lg bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-gray-100 border border-gray-300 dark:border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all duration-200">
                            <button type="submit"
                                class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 rounded-lg font-semibold transition-colors duration-200">
                                Subscribe
                            </button>
                        </form>
                    </div>
                </aside>
            </div>
        </div>
    </div>
</x-blog-header>
<x-footer />