<x-blog-header>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h1 class="text-3xl font-bold mb-4">{{ $post->title }}</h1>
                    
                    @if($post->image)
                        <img src="{{ asset($post->image) }}" alt="{{ $post->title }}" class="w-full h-64 object-cover rounded-md mb-4">
                    @endif
                    
                    <p class="text-gray-700 dark:text-gray-300 mb-4">{{ $post->content }}</p>
                    
                    <small class="text-xs text-gray-500 dark:text-gray-400">
                        By {{ $post->user->name ?? 'Unknown' }} on {{ $post->created_at->format('M d, Y') }}
                        @if($post->category)
                            in <span class="font-semibold">{{ $post->category->name }}</span>
                        @endif
                    </small>
                    
                    {{-- UPDATE HERE: Wrap edit/delete links in auth check --}}
                    @if(auth()->check())
                        <div class="mt-6 flex space-x-4">
                            <a href="{{ route('posts.edit', $post) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Edit</a>
                            <form action="{{ route('posts.destroy', $post) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </div>
                    @endif
                    
                    <div class="mt-6">
                        <a href="{{ route('public.posts.index') }}" class="text-blue-500 hover:text-blue-700">Back to Posts</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-blog-header>