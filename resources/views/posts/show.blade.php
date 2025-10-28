<x-layouts.app>
<div class="max-w-4xl mx-auto py-12 px-4">
    <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100 mb-4">{{ $post->title }}</h1>
        <p class="text-gray-700 dark:text-gray-300 mb-4 leading-relaxed">{{ $post->content }}</p>
        <small class="text-sm text-gray-500 dark:text-gray-400">Posted on {{ $post->created_at->format('M d, Y') }}</small>
        <div class="mt-6 flex space-x-4">
            <a href="{{ route('posts.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white font-medium py-2 px-4 rounded-md transition duration-200">Back to Posts</a>
            <a href="{{ route('posts.edit', $post) }}" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-md transition duration-200">Edit</a>
        </div>
    </div>
</div>
</x-layouts.app>