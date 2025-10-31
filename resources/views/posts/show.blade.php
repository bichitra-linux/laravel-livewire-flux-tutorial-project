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
                        <span>•</span>
                        <span>{{ number_format($post->views) }} views</span>
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

                        {{-- ✨ MOVE REACTIONS HERE (After Content) ✨ --}}
                        <div class="mt-8 pt-6 border-t border-gray-200 dark:border-gray-700">
                            @auth
                                {{-- Authenticated: Always show interactive reactions --}}
                                <x-post-reactions :post="$post" />
                            @else
                                {{-- Unauthenticated: Show read-only if reactions exist --}}
                                @if($post->reactions->count() > 0)
                                    <div class="bg-gray-50 dark:bg-gray-800 rounded-xl p-6">
                                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                                            <svg class="w-5 h-5 text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                            </svg>
                                            Reactions
                                        </h3>

                                        {{-- Reaction breakdown --}}
                                        <div class="flex flex-wrap gap-3 mb-4">
                                            @php
                                                $reactionGroups = $post->reactions->groupBy('type');
                                                $emojis = [
                                                    'like' => '👍',
                                                    'love' => '❤️',
                                                    'care' => '🤗',
                                                    'haha' => '😂',
                                                    'wow' => '😮',
                                                    'sad' => '😢',
                                                    'angry' => '😠'
                                                ];
                                            @endphp
                                            @foreach($reactionGroups as $type => $reactions)
                                                <div class="flex items-center gap-2 bg-white dark:bg-gray-700 rounded-full px-4 py-2 border border-gray-200 dark:border-gray-600">
                                                    <span class="text-2xl">{{ $emojis[$type] ?? '👍' }}</span>
                                                    <span class="text-sm font-semibold text-gray-900 dark:text-white">{{ $reactions->count() }}</span>
                                                    <span class="text-xs text-gray-500 dark:text-gray-400">{{ ucfirst($type) }}</span>
                                                </div>
                                            @endforeach
                                        </div>

                                        <div class="text-sm text-gray-600 dark:text-gray-400 mb-4">
                                            <strong class="text-gray-900 dark:text-white">{{ $post->reactions->count() }}</strong>
                                            {{ Str::plural('person', $post->reactions->count()) }} reacted to this post
                                        </div>

                                        {{-- Login/Register CTA --}}
                                        <div class="mt-6 p-4 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg">
                                            <div class="flex items-start gap-3">
                                                <div class="flex-shrink-0">
                                                    <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                    </svg>
                                                </div>
                                                <div class="flex-1">
                                                    <p class="text-sm font-medium text-gray-900 dark:text-white mb-2">
                                                        Want to react to this post?
                                                    </p>
                                                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-3">
                                                        Sign in to share your reaction and engage with the community.
                                                    </p>
                                                    <div class="flex gap-2">
                                                        <a href="{{ route('login') }}" 
                                                            class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                                                            Sign In
                                                        </a>
                                                        <a href="{{ route('register') }}" 
                                                            class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 text-sm font-medium rounded-lg border border-gray-300 dark:border-gray-600 transition-colors duration-200">
                                                            Create Account
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endauth
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