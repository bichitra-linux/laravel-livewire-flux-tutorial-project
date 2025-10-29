<x-layouts.app>
    <div class="max-w-2xl mx-auto py-10 px-4">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100 mb-8">Create New Post</h1>
        <form action="{{ route('posts.store') }}" method="POST"
            class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md">
            @csrf
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Title:</label>
                <input type="text" name="title" required
                    class="mt-1 block w-full border border-gray-300 dark:border-gray-700 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Content:</label>
                <textarea name="content" rows="5" required
                    class="mt-1 block w-full border border-gray-300 dark:border-gray-700 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50"></textarea>
            </div>
            <div class="mb-3">
                <label for="category_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Category</label>
                <select name="category_id" id="category_id" class="mt-1 block w-full border border-gray-300 dark:border-gray-700 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                    <option value="">— Select category —</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" @selected(old('category_id', $post->category_id ?? '') == $cat->id)>
                            {{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit"
                class="mt-4 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Create Post</button>
        </form>
    </div>
</x-layouts.app>