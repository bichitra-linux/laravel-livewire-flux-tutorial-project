<x-layouts.app>
    <div class="max-w-4xl mx-auto py-10 px-4">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100 mb-8">Edit Post</h1>
        
        <form action="{{ route('posts.update', $post) }}" method="POST" enctype="multipart/form-data"
            class="bg-white dark:bg-gray-800 p-8 rounded-lg shadow-md space-y-6">
            @csrf
            @method('PUT')

            {{-- Title --}}
            <div>
                <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Title <span class="text-red-500">*</span>
                </label>
                <input type="text" id="title" name="title" value="{{ old('title', $post->title) }}" required
                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white @error('title') @enderror">
                @error('title')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Category --}}
            <div>
                <label for="category_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Category
                </label>
                <select name="category_id" id="category_id"
                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                    <option value="">— Select category —</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ old('category_id', $post->category_id) == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Tags --}}
            <div>
                <label for="tags" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Tags
                </label>
                <input type="text" id="tags" name="tags" 
                    value="{{ old('tags', $post->tags->pluck('name')->implode(', ')) }}" 
                    placeholder="e.g., Laravel, PHP, Web Development (comma-separated)"
                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Separate multiple tags with commas</p>
                @error('tags')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Image Upload --}}
            <div>
                <label for="image" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Featured Image
                </label>
                
                @if($post->image)
                    <div class="mb-3 flex items-center space-x-4">
                        <img src="{{ asset('storage/' . $post->image) }}" alt="Current image" 
                            class="h-24 w-24 object-cover rounded-md border-2 border-gray-300 dark:border-gray-600">
                        <div>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Current image</p>
                            <label class="inline-flex items-center mt-2">
                                <input type="checkbox" name="remove_image" value="1" 
                                    class="rounded border-gray-300 text-red-600 shadow-sm focus:ring-red-500 dark:border-gray-600 dark:bg-gray-700">
                                <span class="ml-2 text-sm text-red-600 dark:text-red-400">Remove image</span>
                            </label>
                        </div>
                    </div>
                @endif

                <div class="mt-1 flex items-center space-x-4">
                    <div class="flex-1">
                        <input type="file" id="image" name="image" accept="image/*"
                            class="block w-full text-sm text-gray-500 dark:text-gray-400
                                file:mr-4 file:py-2 file:px-4
                                file:rounded-md file:border-0
                                file:text-sm file:font-semibold
                                file:bg-blue-50 file:text-blue-700
                                hover:file:bg-blue-100
                                dark:file:bg-gray-700 dark:file:text-gray-300
                                dark:hover:file:bg-gray-600
                                cursor-pointer">
                    </div>
                    <div id="image-preview" class="hidden">
                        <img src="" alt="Preview" class="h-20 w-20 object-cover rounded-md border-2 border-gray-300 dark:border-gray-600">
                    </div>
                </div>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                    {{ $post->image ? 'Upload a new image to replace the current one' : 'Max 4MB • 1920×1080 recommended • JPEG, PNG, JPG, GIF, WebP' }}
                </p>
                @error('image')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Content --}}
            <div>
                <label for="content" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Content <span class="text-red-500">*</span>
                </label>
                <input id="content" type="hidden" name="content" value="{{ old('content', $post->content) }}">
                <trix-editor 
                    input="content" 
                    class="trix-content border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white @error('content') @enderror"
                    placeholder="Write your post content here..."></trix-editor>
                @error('content')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                    Use the toolbar above to format your text with <strong>bold</strong>, <em>italic</em>, lists, links, and more.
                </p>
            </div>

            {{-- Status --}}
            <div>
                <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Status <span class="text-red-500">*</span>
                </label>
                <select id="status" name="status" required
                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                    @foreach(App\Enums\PostStatus::cases() as $status)
                        <option value="{{ $status->value }}" {{ old('status', $post->status->value) == $status->value ? 'selected' : '' }}>
                            {{ $status->label() }}
                        </option>
                    @endforeach
                </select>
                @error('status')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Submit Buttons --}}
            <div class="flex gap-4 pt-4">
                <button type="submit"
                    class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-md transition duration-200 shadow-md hover:shadow-lg">
                    Update Post
                </button>
                <a href="{{ route('posts.index') }}"
                    class="flex-1 text-center bg-gray-300 hover:bg-gray-400 dark:bg-gray-600 dark:hover:bg-gray-500 text-gray-800 dark:text-white font-semibold py-3 px-6 rounded-md transition duration-200">
                    Cancel
                </a>
            </div>
        </form>
    </div>

    @push('styles')
    <style>
        /* Trix Editor Dark Mode & Custom Styling */
        trix-toolbar {
            background: white;
            border-radius: 0.375rem 0.375rem 0 0;
            border: 1px solid #d1d5db;
            border-bottom: none;
        }

        .dark trix-toolbar {
            background: #374151;
            border-color: #4b5563;
        }

        trix-editor {
            min-height: 300px;
            max-height: 600px;
            overflow-y: auto;
            padding: 1rem;
            background: white;
            border-radius: 0 0 0.375rem 0.375rem;
        }

        .dark trix-editor {
            background: #374151;
            color: white;
        }

        /* Toolbar buttons dark mode */
        .dark trix-button-group button {
            color: white;
        }

        .dark trix-button-group button:hover {
            background: #4b5563;
        }

        .dark trix-button--icon::before {
            filter: invert(1);
        }

        /* Active button state */
        trix-toolbar .trix-button.trix-active {
            background: #dbeafe;
        }

        .dark trix-toolbar .trix-button.trix-active {
            background: #1e3a8a;
        }

        /* File attachment styling */
        trix-editor .attachment {
            padding: 0.5rem;
            margin: 0.5rem 0;
            background: #f3f4f6;
            border-radius: 0.375rem;
        }

        .dark trix-editor .attachment {
            background: #1f2937;
        }
    </style>
    @endpush

    @push('scripts')
    <script>
        // Image preview
        document.getElementById('image').addEventListener('change', function(e) {
            const file = e.target.files[0];
            const preview = document.getElementById('image-preview');
            const img = preview.querySelector('img');
            
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    img.src = e.target.result;
                    preview.classList.remove('hidden');
                };
                reader.readAsDataURL(file);
            } else {
                preview.classList.add('hidden');
            }
        });

        // Disable file attachments in Trix 
        document.addEventListener("trix-file-accept", function(e) {
            e.preventDefault();
            alert("File attachments are disabled. Please use the Featured Image field above.");
        });
    </script>
    @endpush
</x-layouts.app>