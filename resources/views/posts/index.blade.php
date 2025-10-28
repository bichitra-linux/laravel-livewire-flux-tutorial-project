<x-layouts.app>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-2xl font-semibold">Posts</h3>
                        <a href="{{ route('posts.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-md transition duration-200">
                            Create New Post
                        </a>
                    </div>

                    @if($posts->count() > 0)
                        <div class="space-y-6">
                            @foreach($posts as $post)
                                <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4 hover:shadow-md transition duration-200">
                                    <div class="flex justify-between items-start">
                                        <div class="flex-1">
                                            <h4 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-2">{{ $post->title }}</h4>
                                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">{{ Str::limit($post->content, 150) }}</p>
                                            <small class="text-xs text-gray-500 dark:text-gray-400">{{ $post->created_at->format('M d, Y') }}</small>
                                        </div>
                                        <div class="flex space-x-3 ml-4">
                                            <a href="{{ route('posts.show', $post) }}" class="text-blue-600 hover:text-blue-800 font-medium">View</a>
                                            <a href="{{ route('posts.edit', $post) }}" class="text-yellow-600 hover:text-yellow-800 font-medium">Edit</a>
                                            <form action="{{ route('posts.destroy', $post) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-800 font-medium" onclick="return confirm('Are you sure?')">Delete</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        {{ $posts->links() }}
                    @else
                        <p class="text-gray-500 dark:text-gray-400">You have no posts yet. <a href="{{ route('posts.create') }}" class="text-blue-600 hover:text-blue-800 font-medium">Create your first post!</a></p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>