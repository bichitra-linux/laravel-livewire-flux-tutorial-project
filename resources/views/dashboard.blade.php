<x-layouts.app :title="__('Dashboard')">
    <div class="flex h-full w-full flex-1 flex-col gap-6 rounded-xl p-6">
        {{-- Welcome Section --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-lg">
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Welcome back, {{ auth()->user()->name }}!</h1>
            <p class="text-gray-600 dark:text-gray-300 mt-2">Here's an overview of your blog activity.</p>
        </div>

        {{-- Stats Grid --}}
        <div class="grid gap-4 md:grid-cols-3">
            <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-lg">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-blue-100 dark:bg-blue-900">
                        <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Posts</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $totalPosts }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-lg">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-green-100 dark:bg-green-900">
                        <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Published</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $publishedPosts }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-lg">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-yellow-100 dark:bg-yellow-900">
                        <svg class="w-6 h-6 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Drafts</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $draftPosts }}</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Recent Posts and Actions --}}
        <div class="grid gap-6 md:grid-cols-2">
            {{-- Recent Posts --}}
            <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-lg">
                <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Recent Posts</h2>
                @if($recentPosts->count() > 0)
                    <ul class="space-y-3">
                        @foreach($recentPosts as $post)
                            <li class="flex items-center justify-between">
                                <div>
                                    <a href="{{ route('posts.show', $post) }}" class="text-gray-900 dark:text-white hover:text-blue-600 dark:hover:text-blue-400 font-medium">{{ $post->title }}</a>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">{{ $post->status->label() }} • {{ $post->created_at->diffForHumans() }}</p>
                                </div>
                                <a href="{{ route('posts.edit', $post) }}" class="text-blue-600 dark:text-blue-400 hover:underline text-sm">Edit</a>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-gray-600 dark:text-gray-400">No posts yet. <a href="{{ route('posts.create') }}" class="text-blue-600 hover:underline">Create your first post</a>.</p>
                @endif
            </div>

            {{-- Quick Actions --}}
            <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-lg">
                <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Quick Actions</h2>
                <div class="space-y-3">
                    <a href="{{ route('posts.create') }}" class="block w-full bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-lg font-semibold text-center transition-colors duration-200">Create New Post</a>
                    <a href="{{ route('public.posts.index') }}" class="block w-full bg-gray-600 hover:bg-gray-700 text-white py-2 px-4 rounded-lg font-semibold text-center transition-colors duration-200">View Public Posts</a>
                    <a href="{{ route('profile.edit') }}" class="block w-full bg-green-600 hover:bg-green-700 text-white py-2 px-4 rounded-lg font-semibold text-center transition-colors duration-200">Edit Profile</a>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
