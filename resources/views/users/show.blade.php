<x-layouts.app :title="'User Details - ' . $user->name">
    <div class="flex h-full w-full flex-1 flex-col gap-6 rounded-xl p-6">
        {{-- Back Button --}}
        <div>
            <a href="{{ route('users.index') }}" class="inline-flex items-center gap-2 text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Back to Users
            </a>
        </div>

        {{-- User Profile Header --}}
        <div class="bg-linear-to-r from-indigo-600 to-purple-600 rounded-xl p-6 shadow-lg text-white">
            <div class="flex items-center gap-6">
                {{-- Avatar --}}
                <div class="shrink-0">
                    <div class="w-24 h-24 rounded-full bg-white/20 backdrop-blur-sm flex items-center justify-center text-4xl font-bold border-4 border-white/30">
                        {{ $user->initials() }}
                    </div>
                </div>

                {{-- User Info --}}
                <div class="flex-1">
                    <div class="flex items-center gap-3 mb-2">
                        <h1 class="text-3xl font-bold">{{ $user->name }}</h1>
                        @if($user->email_verified_at)
                            <span class="flex items-center gap-1 bg-green-500/20 text-green-100 px-3 py-1 rounded-full text-sm font-medium">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                Verified
                            </span>
                        @else
                            <span class="flex items-center gap-1 bg-red-500/20 text-red-100 px-3 py-1 rounded-full text-sm font-medium">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                </svg>
                                Not Verified
                            </span>
                        @endif
                    </div>
                    <p class="text-indigo-100 text-lg mb-2">{{ $user->email }}</p>
                    <div class="flex items-center gap-4 text-sm text-indigo-100">
                        <span class="flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            Joined {{ $user->created_at->format('M d, Y') }}
                        </span>
                        <span>•</span>
                        <span>ID: #{{ $user->id }}</span>
                    </div>
                </div>

                {{-- Role Badges --}}
                <div class="flex flex-col gap-2">
                    @if($user->roles->isNotEmpty())
                        @foreach($user->roles as $role)
                            <span class="px-4 py-2 text-sm font-semibold rounded-lg {{ $role->name === 'admin' ? 'bg-red-500/20 text-red-100 border border-red-400/30' : ($role->name === 'editor' ? 'bg-purple-500/20 text-purple-100 border border-purple-400/30' : 'bg-white/20 text-white border border-white/30') }}">
                                {{ ucfirst($role->name) }}
                            </span>
                        @endforeach
                    @else
                        <span class="px-4 py-2 text-sm font-semibold rounded-lg bg-white/20 text-white border border-white/30">
                            User
                        </span>
                    @endif
                </div>
            </div>
        </div>

        {{-- Stats Cards --}}
        <div class="grid gap-4 md:grid-cols-4">
            {{-- Total Posts --}}
            <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-lg">
                <div class="flex items-center gap-3">
                    <div class="p-3 rounded-full bg-blue-100 dark:bg-blue-900/30">
                        <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Total Posts</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $user->posts->count() }}</p>
                    </div>
                </div>
            </div>

            {{-- Published Posts --}}
            <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-lg">
                <div class="flex items-center gap-3">
                    <div class="p-3 rounded-full bg-green-100 dark:bg-green-900/30">
                        <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Published</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">
                            {{ $user->posts->where('status', \App\Enums\PostStatus::Published)->count() }}
                        </p>
                    </div>
                </div>
            </div>

            {{-- Total Reactions --}}
            <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-lg">
                <div class="flex items-center gap-3">
                    <div class="p-3 rounded-full bg-pink-100 dark:bg-pink-900/30">
                        <svg class="w-6 h-6 text-pink-600 dark:text-pink-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Reactions Given</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $user->reactions->count() }}</p>
                    </div>
                </div>
            </div>

            {{-- Total Views --}}
            <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-lg">
                <div class="flex items-center gap-3">
                    <div class="p-3 rounded-full bg-purple-100 dark:bg-purple-900/30">
                        <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Total Views</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ number_format($user->posts->sum('views')) }}</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Main Content Grid --}}
        <div class="grid gap-6 lg:grid-cols-3">
            {{-- User Posts (2 columns) --}}
            <div class="lg:col-span-2 bg-white dark:bg-gray-800 rounded-xl p-6 shadow-lg">
                <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                    <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    User Posts ({{ $user->posts->count() }})
                </h2>

                @if($user->posts->count() > 0)
                    <div class="space-y-3">
                        @foreach($user->posts->take(10) as $post)
                            <div class="flex items-start gap-4 p-4 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors group">
                                {{-- Post Image/Icon --}}
                                @if($post->image)
                                    <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}" class="w-16 h-16 rounded-lg object-cover shrink-0">
                                @else
                                    <div class="w-16 h-16 rounded-lg bg-linear-to-br from-blue-500 to-purple-500 flex items-center justify-center shrink-0">
                                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                    </div>
                                @endif

                                {{-- Post Info --}}
                                <div class="flex-1 min-w-0">
                                    <a href="{{ route('public.posts.show', $post) }}" class="text-gray-900 dark:text-white group-hover:text-blue-600 dark:group-hover:text-blue-400 font-semibold line-clamp-1 transition-colors">
                                        {{ $post->title }}
                                    </a>
                                    <div class="flex items-center gap-3 mt-1 text-xs text-gray-500 dark:text-gray-400">
                                        @if($post->category)
                                            <span class="flex items-center gap-1">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                                </svg>
                                                {{ $post->category->name }}
                                            </span>
                                        @endif
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
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-12">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <p class="mt-4 text-gray-600 dark:text-gray-400">No posts yet.</p>
                    </div>
                @endif
            </div>

            {{-- User Details & Activity (1 column) --}}
            <div class="space-y-6">
                {{-- Account Details --}}
                <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-lg">
                    <h2 class="text-lg font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Account Details
                    </h2>
                    <div class="space-y-3 text-sm">
                        <div>
                            <p class="text-gray-600 dark:text-gray-400">Email</p>
                            <p class="text-gray-900 dark:text-white font-medium">{{ $user->email }}</p>
                        </div>
                        <div>
                            <p class="text-gray-600 dark:text-gray-400">Member Since</p>
                            <p class="text-gray-900 dark:text-white font-medium">{{ $user->created_at->format('F j, Y') }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ $user->created_at->diffForHumans() }}</p>
                        </div>
                        <div>
                            <p class="text-gray-600 dark:text-gray-400">Email Verification</p>
                            @if($user->email_verified_at)
                                <p class="text-green-600 dark:text-green-400 font-medium flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                    Verified on {{ $user->email_verified_at->format('M d, Y') }}
                                </p>
                            @else
                                <p class="text-red-600 dark:text-red-400 font-medium flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                    </svg>
                                    Not Verified
                                </p>
                            @endif
                        </div>
                        <div>
                            <p class="text-gray-600 dark:text-gray-400">Roles</p>
                            <div class="flex flex-wrap gap-2 mt-1">
                                @if($user->roles->isNotEmpty())
                                    @foreach($user->roles as $role)
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $role->name === 'admin' ? 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400' : ($role->name === 'editor' ? 'bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-400' : 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300') }}">
                                            {{ ucfirst($role->name) }}
                                        </span>
                                    @endforeach
                                @else
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300">
                                        User
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Recent Activity --}}
                <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-lg">
                    <h2 class="text-lg font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                        Recent Activity
                    </h2>
                    <div class="space-y-3">
                        @if($user->reactions->count() > 0)
                            @foreach($user->reactions->take(5) as $reaction)
                                <div class="flex items-start gap-3 text-sm">
                                    <span class="text-xl">{{ $reaction->emoji }}</span>
                                    <div class="flex-1">
                                        <p class="text-gray-900 dark:text-white">
                                            Reacted to <a href="{{ route('public.posts.show', $reaction->post) }}" class="text-blue-600 dark:text-blue-400 hover:underline">{{ Str::limit($reaction->post->title, 30) }}</a>
                                        </p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ $reaction->created_at->diffForHumans() }}</p>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <p class="text-center text-gray-500 dark:text-gray-400 py-4">No recent activity</p>
                        @endif
                    </div>
                </div>

                {{-- Actions --}}
                @if(auth()->id() !== $user->id)
                    <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-lg">
                        <h2 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Actions</h2>
                        <form action="{{ route('users.destroy', $user) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this user? This action cannot be undone.');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white py-2 rounded-lg font-medium transition-colors duration-200 flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                                Delete User
                            </button>
                        </form>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-layouts.app>