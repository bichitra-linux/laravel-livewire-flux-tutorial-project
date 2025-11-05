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
                                {{-- ✅ Authenticated: Show FULL interactive reactions --}}
                                <x-post-reactions :post="$post" :compact="false" />
                            @else
                                {{-- ✅ Unauthenticated: Show read-only with login CTA --}}
                                @if($post->reactions->count() > 0)
                                    <div class="bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-800 dark:to-gray-900 rounded-2xl p-6 border border-gray-200 dark:border-gray-700">
                                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                                            <svg class="w-5 h-5 text-pink-500" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"></path>
                                            </svg>
                                            Reactions to this post
                                        </h3>

                                        {{-- Reaction Grid --}}
                                        <div class="grid grid-cols-7 gap-3 mb-6">
                                            @php
                                                $reactionCounts = $post->reaction_counts;
                                                $emojis = [
                                                    'like' => '👍', 'love' => '❤️', 'care' => '🤗',
                                                    'haha' => '😂', 'wow' => '😮', 'sad' => '😢', 'angry' => '😠'
                                                ];
                                            @endphp
                                            @foreach(['like', 'love', 'care', 'haha', 'wow', 'sad', 'angry'] as $type)
                                                <div class="flex flex-col items-center p-3 rounded-xl bg-white dark:bg-gray-700 border-2 border-gray-200 dark:border-gray-600 {{ isset($reactionCounts[$type]) && $reactionCounts[$type] > 0 ? 'ring-2 ring-blue-300 dark:ring-blue-600' : 'opacity-50' }}">
                                                    <span class="text-3xl mb-1">{{ $emojis[$type] }}</span>
                                                    <span class="text-sm font-bold text-gray-900 dark:text-white">
                                                        {{ $reactionCounts[$type] ?? 0 }}
                                                    </span>
                                                    <span class="text-xs text-gray-500 dark:text-gray-400 capitalize">
                                                        {{ $type }}
                                                    </span>
                                                </div>
                                            @endforeach
                                        </div>

                                        <div class="text-center mb-4">
                                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                                <strong class="text-gray-900 dark:text-white">{{ $post->total_reactions }}</strong>
                                                {{ Str::plural('person', $post->total_reactions) }} reacted to this post
                                            </p>
                                        </div>

                                        {{-- ✅ Login CTA --}}
                                        <div class="p-4 bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 border-2 border-blue-200 dark:border-blue-800 rounded-xl">
                                            <div class="flex items-start gap-3">
                                                <div class="flex-shrink-0">
                                                    <svg class="w-8 h-8 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                                    </svg>
                                                </div>
                                                <div class="flex-1">
                                                    <h4 class="text-base font-bold text-gray-900 dark:text-white mb-1">
                                                        Love this post?
                                                    </h4>
                                                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-3">
                                                        Sign in to share your reaction and see what others think!
                                                    </p>
                                                    <div class="flex gap-2">
                                                        <a href="{{ route('login') }}"
                                                            class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-lg shadow-md hover:shadow-lg transition-all duration-200">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                                                            </svg>
                                                            Sign In
                                                        </a>
                                                        <a href="{{ route('register') }}"
                                                            class="inline-flex items-center gap-2 px-4 py-2 bg-white dark:bg-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 text-sm font-semibold rounded-lg border-2 border-gray-300 dark:border-gray-600 shadow-sm hover:shadow-md transition-all duration-200">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                                                            </svg>
                                                            Create Account
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    {{-- No reactions yet --}}
                                    <div class="text-center p-8 bg-gray-50 dark:bg-gray-800 rounded-xl border-2     border-dashed border-gray-300 dark:border-gray-600">
                                        <svg class="w-16 h-16 mx-auto text-gray-400 dark:text-gray-500 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                        </svg>
                                        <p class="text-gray-600 dark:text-gray-400 mb-4">
                                            Be the first to react to this post!
                                        </p>
                                        <a href="{{ route('login') }}" class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg shadow-md hover:shadow-lg transition-all duration-200">
                                            Sign In to React
                                        </a>
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

                    {{-- Comment Section (Livewire with auto-refresh) --}}
                    @livewire('comment-section', ['post' => $post])

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


                </aside>
            </div>
        </div>
    </div>
</x-blog-header>
<x-footer />