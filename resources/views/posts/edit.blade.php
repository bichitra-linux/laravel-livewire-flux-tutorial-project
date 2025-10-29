<x-layouts.app>
<div class="max-w-2xl mx-auto py-10 px-4">
    <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100 mb-8">Edit Post</h1>
    <form action="{{ route('posts.update', $post) }}" method="POST" class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Title</label>
            <input type="text" class="mt-1 block w-full border border-gray-300 dark:border-gray-700 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" id="title" name="title" value="{{ $post->title }}" required>
        </div>
        <div class="mb-3">
            <label for="content" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Content</label>
            <textarea class="mt-1 block w-full border border-gray-300 dark:border-gray-700 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" id="content" name="content" rows="5" required>{{ $post->content }}</textarea>
        </div>
        <div class="mb-3">
            <label for="category_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Category</label>
            <select name="category_id" id="category_id" class="mt-1 block w-full border text-gray-700 dark:text-gray-100 border-gray-300 dark:border-gray-700 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 bg-gray-100 dark:bg-gray-800">
                <option value="">— Select category —</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" @selected(old('category_id', $post->category_id ?? '') == $cat->id)>{{ $cat->name }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="mt-4 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Update Post</button>
    </form>
</div>
</x-layouts.app>