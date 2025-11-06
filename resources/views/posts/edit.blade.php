<x-layouts.app>
    <div class="min-h-screen bg-gradient-to-br from-zinc-50 via-white to-zinc-50 dark:from-zinc-900 dark:via-zinc-800 dark:to-zinc-900 py-12 px-4">
        <div class="max-w-5xl mx-auto">
            {{-- Header Section --}}
            <div class="mb-8">
                <div class="flex items-center gap-4 mb-4">
                    <a href="{{ route('posts.index') }}" 
                        class="flex items-center justify-center w-10 h-10 rounded-lg bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 hover:bg-zinc-50 dark:hover:bg-zinc-700 transition-colors">
                        <svg class="w-5 h-5 text-zinc-600 dark:text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                    </a>
                    <div>
                        <h1 class="text-4xl font-bold text-zinc-900 dark:text-white flex items-center gap-3">
                            <svg class="w-10 h-10 text-amber-600 dark:text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                            Edit Post
                        </h1>
                        <p class="text-zinc-600 dark:text-zinc-400 mt-2">Update your post content and settings</p>
                    </div>
                </div>
            </div>

            <form action="{{ route('posts.update', $post) }}" method="POST" enctype="multipart/form-data" id="post-form">
                @csrf
                @method('PUT')

                <div class="grid lg:grid-cols-3 gap-6">
                    {{-- Main Content Section --}}
                    <div class="lg:col-span-2 space-y-6">
                        {{-- Title Card --}}
                        <div class="bg-white dark:bg-zinc-800 rounded-xl shadow-lg border border-zinc-200 dark:border-zinc-700 p-6 hover:shadow-xl transition-shadow">
                            <div class="flex items-center gap-3 mb-4">
                                <div class="p-2 rounded-lg bg-blue-100 dark:bg-blue-900/30">
                                    <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <label for="title" class="block text-sm font-semibold text-zinc-900 dark:text-white">
                                        Post Title <span class="text-red-500">*</span>
                                    </label>
                                    <p class="text-xs text-zinc-500 dark:text-zinc-400">A catchy title helps attract readers</p>
                                </div>
                            </div>
                            <input type="text" id="title" name="title" value="{{ old('title', $post->title) }}" required
                                placeholder="Enter an engaging post title..."
                                class="w-full px-4 py-3 text-lg border-2 border-zinc-200 dark:border-zinc-700 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-zinc-900 dark:text-white transition-all @error('title') @enderror">
                            @error('title')
                                <p class="text-red-500 text-sm mt-2 flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- Content Card with Quill --}}
                        <div class="bg-white dark:bg-zinc-800 rounded-xl shadow-lg border border-zinc-200 dark:border-zinc-700 p-6 hover:shadow-xl transition-shadow">
                            <div class="flex items-center gap-3 mb-4">
                                <div class="p-2 rounded-lg bg-purple-100 dark:bg-purple-900/30">
                                    <svg class="w-5 h-5 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <label for="content" class="block text-sm font-semibold text-zinc-900 dark:text-white">
                                        Content <span class="text-red-500">*</span>
                                    </label>
                                    <p class="text-xs text-zinc-500 dark:text-zinc-400">Tell your story with rich formatting</p>
                                </div>
                            </div>
                            
                            {{-- Quill Editor --}}
                            <div id="quill-editor" class="bg-white dark:bg-zinc-900 rounded-lg border-2 border-zinc-200 dark:border-zinc-700 @error('content') @enderror"></div>
                            <input type="hidden" name="content" id="content" value="{{ old('content', $post->content) }}">
                            
                            @error('content')
                                <p class="text-red-500 text-sm mt-2 flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- Featured Image Card --}}
                        <div class="bg-white dark:bg-zinc-800 rounded-xl shadow-lg border border-zinc-200 dark:border-zinc-700 p-6 hover:shadow-xl transition-shadow">
                            <div class="flex items-center gap-3 mb-4">
                                <div class="p-2 rounded-lg bg-green-100 dark:bg-green-900/30">
                                    <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <label for="image" class="block text-sm font-semibold text-zinc-900 dark:text-white">
                                        Featured Image
                                    </label>
                                    <p class="text-xs text-zinc-500 dark:text-zinc-400">Add or update the visual appeal of your post</p>
                                </div>
                            </div>

                            @if($post->image)
                                <div class="mb-4 relative group">
                                    <img src="{{ asset('storage/' . $post->image) }}" alt="Current image" 
                                        class="w-full h-64 object-cover rounded-lg border-2 border-zinc-200 dark:border-zinc-700">
                                    <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition-opacity rounded-lg flex items-center justify-center">
                                        <label class="inline-flex items-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg cursor-pointer transition-colors">
                                            <input type="checkbox" name="remove_image" value="1" class="mr-2">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                            Remove Image
                                        </label>
                                    </div>
                                </div>
                            @endif
                            
                            <div class="relative">
                                <input type="file" id="image" name="image" accept="image/*" class="hidden">
                                <label for="image" class="flex flex-col items-center justify-center w-full h-64 border-2 border-dashed border-zinc-300 dark:border-zinc-600 rounded-lg cursor-pointer bg-zinc-50 dark:bg-zinc-900 hover:bg-zinc-100 dark:hover:bg-zinc-800 transition-colors">
                                    <div id="upload-area" class="flex flex-col items-center justify-center pt-5 pb-6">
                                        <svg class="w-12 h-12 mb-4 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                        </svg>
                                        <p class="mb-2 text-sm text-zinc-600 dark:text-zinc-400">
                                            <span class="font-semibold">{{ $post->image ? 'Click to replace image' : 'Click to upload' }}</span> or drag and drop
                                        </p>
                                        <p class="text-xs text-zinc-500 dark:text-zinc-400">PNG, JPG, GIF, WebP (MAX. 4MB)</p>
                                    </div>
                                    <div id="image-preview" class="hidden w-full h-full">
                                        <img src="" alt="Preview" class="w-full h-full object-cover rounded-lg">
                                    </div>
                                </label>
                            </div>
                            @error('image')
                                <p class="text-red-500 text-sm mt-2 flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>

                    {{-- Sidebar Section --}}
                    <div class="space-y-8">
                        {{-- Publish Card --}}
                        <div class="bg-white dark:bg-zinc-800 rounded-xl shadow-lg border border-zinc-200 dark:border-zinc-700 p-6 sticky top-8">
                            <div class="flex items-center gap-3 mb-4">
                                <div class="p-2 rounded-lg bg-yellow-100 dark:bg-yellow-900/30">
                                    <svg class="w-5 h-5 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <h3 class="text-sm font-semibold text-zinc-900 dark:text-white">Publishing</h3>
                            </div>
                            
                            {{-- Status --}}
                            <div class="mb-4">
                                <label for="status" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                                    Status <span class="text-red-500">*</span>
                                </label>
                                <select id="status" name="status" required
                                    class="w-full px-4 py-2.5 border-2 border-zinc-200 dark:border-zinc-700 rounded-lg shadow-sm focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 dark:bg-zinc-900 dark:text-white transition-all">
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

                            {{-- Category --}}
                            <div class="mb-4">
                                <label for="category_id" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                                    Category
                                </label>
                                <select name="category_id" id="category_id"
                                    class="w-full px-4 py-2.5 border-2 border-zinc-200 dark:border-zinc-700 rounded-lg shadow-sm focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 dark:bg-zinc-900 dark:text-white transition-all">
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
                            <div class="mb-6">
                                <label for="tags" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                                    Tags
                                </label>
                                <input type="text" id="tags" name="tags" value="{{ old('tags', $post->tags->pluck('name')->implode(', ')) }}" 
                                    placeholder="Laravel, PHP, Web Dev..."
                                    class="w-full px-4 py-2.5 border-2 border-zinc-200 dark:border-zinc-700 rounded-lg shadow-sm focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 dark:bg-zinc-900 dark:text-white transition-all">
                                <p class="text-xs text-zinc-500 dark:text-zinc-400 mt-1.5 flex items-center gap-1">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Separate with commas
                                </p>
                                @error('tags')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Post Meta Info --}}
                            <div class="mb-6 p-4 bg-zinc-50 dark:bg-zinc-900 rounded-lg border border-zinc-200 dark:border-zinc-700">
                                <h4 class="text-sm font-semibold text-zinc-900 dark:text-white mb-3">Post Information</h4>
                                <div class="space-y-2 text-xs text-zinc-600 dark:text-zinc-400">
                                    <div class="flex items-center justify-between">
                                        <span>Created:</span>
                                        <span class="font-medium">{{ $post->created_at->format('M d, Y') }}</span>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <span>Last Updated:</span>
                                        <span class="font-medium">{{ $post->updated_at->diffForHumans() }}</span>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <span>Author:</span>
                                        <span class="font-medium">{{ $post->user->name }}</span>
                                    </div>
                                </div>
                            </div>

                            {{-- Action Buttons --}}
                            <div class="space-y-3 pt-4 border-t border-zinc-200 dark:border-zinc-700">
                                <button type="submit"
                                    class="w-full flex items-center justify-center gap-2 bg-gradient-to-r from-amber-600 to-amber-700 hover:from-amber-700 hover:to-amber-800 text-white font-semibold py-3 px-6 rounded-lg transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    Update Post
                                </button>
                                <a href="{{ route('posts.show', $post) }}"
                                    class="w-full flex items-center justify-center gap-2 bg-blue-100 hover:bg-blue-200 dark:bg-blue-900/30 dark:hover:bg-blue-900/50 text-blue-700 dark:text-blue-400 font-semibold py-3 px-6 rounded-lg transition-all duration-200">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                    Preview Post
                                </a>
                                <a href="{{ route('posts.index') }}"
                                    class="w-full flex items-center justify-center gap-2 bg-zinc-200 hover:bg-zinc-300 dark:bg-zinc-700 dark:hover:bg-zinc-600 text-zinc-800 dark:text-white font-semibold py-3 px-6 rounded-lg transition-all duration-200">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                    Cancel
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @push('styles')
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.snow.css" rel="stylesheet">
    <style>
        /* Quill Editor Custom Styling */
        #quill-editor {
            min-height: 400px;
        }

        .ql-container {
            font-size: 16px;
            line-height: 1.8;
        }

        .ql-editor {
            min-height: 400px;
            padding: 1.5rem;
        }

        .ql-editor.ql-blank::before {
            color: #9ca3af;
            font-style: normal;
        }

        /* Dark mode for Quill */
        .dark .ql-toolbar {
            background: #18181b;
            border-color: #3f3f46 !important;
        }

        .dark .ql-container {
            background: #18181b;
            border-color: #3f3f46 !important;
        }

        .dark .ql-editor {
            color: white;
        }

        .dark .ql-stroke {
            stroke: #d4d4d8;
        }

        .dark .ql-fill {
            fill: #d4d4d8;
        }

        .dark .ql-picker-label {
            color: #d4d4d8;
        }

        .dark .ql-picker-options {
            background: #27272a;
            border-color: #3f3f46;
        }

        .dark .ql-picker-item:hover {
            background: #3f3f46;
            color: white;
        }

        .dark .ql-toolbar button:hover,
        .dark .ql-toolbar button.ql-active {
            background: #3f3f46;
        }

        .dark .ql-toolbar button:hover .ql-stroke,
        .dark .ql-toolbar button.ql-active .ql-stroke {
            stroke: #3b82f6;
        }

        .dark .ql-toolbar button:hover .ql-fill,
        .dark .ql-toolbar button.ql-active .ql-fill {
            fill: #3b82f6;
        }

        /* Better heading styles */
        .ql-editor h1 {
            font-size: 2em;
            font-weight: bold;
            margin: 0.67em 0;
        }

        .ql-editor h2 {
            font-size: 1.5em;
            font-weight: bold;
            margin: 0.75em 0;
        }

        .ql-editor h3 {
            font-size: 1.17em;
            font-weight: bold;
            margin: 0.83em 0;
        }

        .ql-editor blockquote {
            border-left: 4px solid #3b82f6;
            padding-left: 1em;
            margin: 1em 0;
            font-style: italic;
        }

        .dark .ql-editor blockquote {
            border-left-color: #60a5fa;
        }

        .ql-editor pre {
            background: #f4f4f5;
            padding: 1em;
            border-radius: 0.5rem;
            overflow-x: auto;
        }

        .dark .ql-editor pre {
            background: #27272a;
        }

        .ql-editor code {
            background: #f4f4f5;
            padding: 0.2em 0.4em;
            border-radius: 0.25rem;
            font-family: 'Courier New', monospace;
        }

        .dark .ql-editor code {
            background: #27272a;
        }
    </style>
    @endpush

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>
    <script>
        // Initialize Quill Editor
        const quill = new Quill('#quill-editor', {
            theme: 'snow',
            modules: {
                toolbar: [
                    [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
                    [{ 'font': [] }],
                    [{ 'size': ['small', false, 'large', 'huge'] }],
                    ['bold', 'italic', 'underline', 'strike'],
                    [{ 'color': [] }, { 'background': [] }],
                    [{ 'script': 'sub'}, { 'script': 'super' }],
                    [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                    [{ 'indent': '-1'}, { 'indent': '+1' }],
                    [{ 'align': [] }],
                    ['blockquote', 'code-block'],
                    ['link', 'image', 'video'],
                    ['clean']
                ]
            },
            placeholder: 'Edit your post content here...'
        });

        // Load existing content
        const existingContent = document.querySelector('#content').value;
        if (existingContent) {
            quill.root.innerHTML = existingContent;
        }

        // Update hidden input on form submit
        document.getElementById('post-form').addEventListener('submit', function(e) {
            const content = document.querySelector('#content');
            content.value = quill.root.innerHTML;
            
            // Validate content is not empty
            if (quill.getText().trim().length === 0) {
                e.preventDefault();
                alert('Please add some content to your post');
                return false;
            }
        });

        // Image preview functionality
        const imageInput = document.getElementById('image');
        const uploadArea = document.getElementById('upload-area');
        const imagePreview = document.getElementById('image-preview');
        const img = imagePreview.querySelector('img');

        imageInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    img.src = e.target.result;
                    uploadArea.classList.add('hidden');
                    imagePreview.classList.remove('hidden');
                };
                reader.readAsDataURL(file);
            } else {
                uploadArea.classList.remove('hidden');
                imagePreview.classList.add('hidden');
            }
        });

        // Drag and drop support
        const label = document.querySelector('label[for="image"]');
        
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            label.addEventListener(eventName, preventDefaults, false);
        });

        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }

        ['dragenter', 'dragover'].forEach(eventName => {
            label.addEventListener(eventName, highlight, false);
        });

        ['dragleave', 'drop'].forEach(eventName => {
            label.addEventListener(eventName, unhighlight, false);
        });

        function highlight() {
            label.classList.add('border-blue-500', 'bg-blue-50', 'dark:bg-blue-900/20');
        }

        function unhighlight() {
            label.classList.remove('border-blue-500', 'bg-blue-50', 'dark:bg-blue-900/20');
        }

        label.addEventListener('drop', handleDrop, false);

        function handleDrop(e) {
            const dt = e.dataTransfer;
            const files = dt.files;
            imageInput.files = files;
            imageInput.dispatchEvent(new Event('change'));
        }
    </script>
    @endpush
</x-layouts.app>