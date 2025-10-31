<x-layouts.app :title="__('Dashboard')">
    <div class="flex h-full w-full flex-1 flex-col gap-6 rounded-xl p-6">
        {{-- Welcome Section with Time-based Greeting --}}
        <div class="bg-gradient-to-r from-blue-600 to-purple-600 rounded-xl p-6 shadow-lg text-white">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold">
                        @php
                            $hour = now()->hour;
                            $greeting = $hour < 12 ? 'Good Morning' : ($hour < 18 ? 'Good Afternoon' : 'Good Evening');
                        @endphp
                        {{ $greeting }}, {{ auth()->user()->name }}! 👋
                    </h1>
                    <p class="text-blue-100 mt-2">Here's what's happening with your blog today.</p>
                </div>
                <div class="hidden md:block">
                    <svg class="w-24 h-24 opacity-50" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5zM8 7a1 1 0 011-1h2a1 1 0 011 1v9a1 1 0 01-1 1H9a1 1 0 01-1-1V7zM14 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1h-2a1 1 0 01-1-1V4z"></path>
                    </svg>
                </div>
            </div>
        </div>

        {{-- Main Stats Grid --}}
        <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-4">
            {{-- Total Posts --}}
            <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-lg hover:shadow-xl transition-shadow duration-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Posts</p>
                        <p class="text-3xl font-bold text-gray-900 dark:text-white mt-2">{{ number_format($totalPosts) }}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">All time</p>
                    </div>
                    <div class="p-3 rounded-full bg-blue-100 dark:bg-blue-900/30">
                        <svg class="w-8 h-8 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            {{-- Published Posts --}}
            <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-lg hover:shadow-xl transition-shadow duration-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Published</p>
                        <p class="text-3xl font-bold text-gray-900 dark:text-white mt-2">{{ number_format($publishedPosts) }}</p>
                        <p class="text-xs text-green-600 dark:text-green-400 mt-1">
                            {{ $totalPosts > 0 ? round(($publishedPosts / $totalPosts) * 100) : 0 }}% of total
                        </p>
                    </div>
                    <div class="p-3 rounded-full bg-green-100 dark:bg-green-900/30">
                        <svg class="w-8 h-8 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            {{-- Draft Posts --}}
            <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-lg hover:shadow-xl transition-shadow duration-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Drafts</p>
                        <p class="text-3xl font-bold text-gray-900 dark:text-white mt-2">{{ number_format($draftPosts) }}</p>
                        <p class="text-xs text-yellow-600 dark:text-yellow-400 mt-1">Pending publication</p>
                    </div>
                    <div class="p-3 rounded-full bg-yellow-100 dark:bg-yellow-900/30">
                        <svg class="w-8 h-8 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            {{-- Newsletter Subscribers --}}
            <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-lg hover:shadow-xl transition-shadow duration-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Subscribers</p>
                        <p class="text-3xl font-bold text-gray-900 dark:text-white mt-2">{{ number_format($newsletterSubscribers) }}</p>
                        <p class="text-xs text-purple-600 dark:text-purple-400 mt-1">
                            +{{ $newSubscribersToday }} today
                        </p>
                    </div>
                    <div class="p-3 rounded-full bg-purple-100 dark:bg-purple-900/30">
                        <svg class="w-8 h-8 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        {{-- Secondary Stats Row --}}
        <div class="grid gap-4 md:grid-cols-3">
            {{-- Total Views --}}
            <div class="bg-white dark:bg-gray-800 rounded-xl p-4 shadow-lg">
                <div class="flex items-center gap-3">
                    <div class="p-2 rounded-lg bg-indigo-100 dark:bg-indigo-900/30">
                        <svg class="w-6 h-6 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs text-gray-600 dark:text-gray-400">Total Views</p>
                        <p class="text-xl font-bold text-gray-900 dark:text-white">{{ number_format($totalViews) }}</p>
                    </div>
                </div>
            </div>

            {{-- Total Reactions --}}
            <div class="bg-white dark:bg-gray-800 rounded-xl p-4 shadow-lg">
                <div class="flex items-center gap-3">
                    <div class="p-2 rounded-lg bg-pink-100 dark:bg-pink-900/30">
                        <svg class="w-6 h-6 text-pink-600 dark:text-pink-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs text-gray-600 dark:text-gray-400">Total Reactions</p>
                        <p class="text-xl font-bold text-gray-900 dark:text-white">{{ number_format($totalReactions) }}</p>
                    </div>
                </div>
            </div>

            {{-- Categories --}}
            <div class="bg-white dark:bg-gray-800 rounded-xl p-4 shadow-lg">
                <div class="flex items-center gap-3">
                    <div class="p-2 rounded-lg bg-teal-100 dark:bg-teal-900/30">
                        <svg class="w-6 h-6 text-teal-600 dark:text-teal-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs text-gray-600 dark:text-gray-400">Categories</p>
                        <p class="text-xl font-bold text-gray-900 dark:text-white">{{ $totalCategories }}</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Main Content Grid --}}
        <div class="grid gap-6 lg:grid-cols-3">
            {{-- Recent Posts (Larger Column) --}}
            <div class="lg:col-span-2 bg-white dark:bg-gray-800 rounded-xl p-6 shadow-lg">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white flex items-center gap-2">
                        <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                        </svg>
                        Recent Posts
                    </h2>
                    <a href="{{ route('posts.index') }}" class="text-sm text-blue-600 dark:text-blue-400 hover:underline">View All →</a>
                </div>
                
                @if($recentPosts->count() > 0)
                    <div class="space-y-3">
                        @foreach($recentPosts as $post)
                            <div class="flex items-start gap-4 p-4 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors group">
                                {{-- Post Image/Icon --}}
                                @if($post->image)
                                    <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}" class="w-16 h-16 rounded-lg object-cover flex-shrink-0">
                                @else
                                    <div class="w-16 h-16 rounded-lg bg-gradient-to-br from-blue-500 to-purple-500 flex items-center justify-center flex-shrink-0">
                                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                    </div>
                                @endif

                                {{-- Post Info --}}
                                <div class="flex-1 min-w-0">
                                    <a href="{{ route('posts.show', $post) }}" class="text-gray-900 dark:text-white group-hover:text-blue-600 dark:group-hover:text-blue-400 font-semibold line-clamp-1 transition-colors">
                                        {{ $post->title }}
                                    </a>
                                    <div class="flex items-center gap-3 mt-1 text-xs text-gray-500 dark:text-gray-400">
                                        <span class="flex items-center gap-1">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                            </svg>
                                            {{ $post->category?->name ?? 'Uncategorized' }}
                                        </span>
                                        <span class="flex items-center gap-1">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                            {{ number_format($post->views) }}
                                        </span>
                                        <span>{{ $post->created_at->diffForHumans() }}</span>
                                    </div>
                                    <div class="flex items-center gap-2 mt-2">
                                        <span class="px-2 py-0.5 text-xs font-medium rounded-full {{ $post->status->value === 'published' ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400' : 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400' }}">
                                            {{ $post->status->label() }}
                                        </span>
                                    </div>
                                </div>

                                {{-- Actions --}}
                                <a href="{{ route('posts.edit', $post) }}" class="opacity-0 group-hover:opacity-100 transition-opacity text-blue-600 dark:text-blue-400 hover:underline text-sm whitespace-nowrap">
                                    Edit →
                                </a>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-12">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <p class="mt-4 text-gray-600 dark:text-gray-400">No posts yet.</p>
                        <a href="{{ route('posts.create') }}" class="mt-2 inline-flex items-center text-blue-600 dark:text-blue-400 hover:underline">
                            Create your first post →
                        </a>
                    </div>
                @endif
            </div>

            {{-- Quick Actions --}}
            <div class="space-y-6">
                {{-- Actions Card --}}
                <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-lg">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                        <svg class="w-6 h-6 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                        Quick Actions
                    </h2>
                    <div class="space-y-2">
                        <a href="{{ route('posts.create') }}" class="flex items-center gap-3 w-full bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white py-3 px-4 rounded-lg font-semibold transition-all duration-200 shadow-sm hover:shadow-md">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            Create New Post
                        </a>
                        <a href="{{ route('public.posts.index') }}" class="flex items-center gap-3 w-full bg-gray-600 hover:bg-gray-700 text-white py-3 px-4 rounded-lg font-semibold transition-colors duration-200">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                            View Public Site
                        </a>
                        <a href="{{ route('newsletter.index') }}" class="flex items-center gap-3 w-full bg-purple-600 hover:bg-purple-700 text-white py-3 px-4 rounded-lg font-semibold transition-colors duration-200">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                            Manage Newsletter
                        </a>
                        <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 w-full bg-green-600 hover:bg-green-700 text-white py-3 px-4 rounded-lg font-semibold transition-colors duration-200">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            Edit Profile
                        </a>
                    </div>
                </div>

                {{-- Top Categories --}}
                @if($topCategories->count() > 0)
                <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-lg">
                    <h2 class="text-lg font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-teal-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                        </svg>
                        Top Categories
                    </h2>
                    <div class="space-y-2">
                        @foreach($topCategories as $category)
                        <div class="flex items-center justify-between p-2 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700/50">
                            <span class="text-sm text-gray-900 dark:text-white">{{ $category->name }}</span>
                            <span class="text-xs font-semibold px-2 py-1 rounded-full bg-teal-100 text-teal-800 dark:bg-teal-900/30 dark:text-teal-400">
                                {{ $category->posts_count }}
                            </span>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</x-layouts.app>