<x-layouts.app>
    <div
        class="min-h-screen bg-linear-to-br from-zinc-50 via-white to-zinc-50 dark:from-zinc-900 dark:via-zinc-800 dark:to-zinc-900 py-12 px-4">
        <div class="max-w-5xl mx-auto">
            {{-- Header Section --}}
            <div class="mb-8">
                <div class="flex items-center gap-4 mb-4">
                    <a href="{{ route('posts.index') }}"
                        class="flex items-center justify-center w-10 h-10 rounded-lg bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 hover:bg-zinc-50 dark:hover:bg-zinc-700 transition-colors">
                        <svg class="w-5 h-5 text-zinc-600 dark:text-zinc-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                    </a>
                    <div>
                        <h1 class="text-4xl font-bold text-zinc-900 dark:text-white flex items-center gap-3">
                            <svg class="w-10 h-10 text-blue-600 dark:text-blue-500" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                </path>
                            </svg>
                            Create New Post
                        </h1>
                        <p class="text-zinc-600 dark:text-zinc-400 mt-2">Share your thoughts with the world</p>
                    </div>
                </div>
            </div>

            <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data" id="post-form">
                @csrf

                <div class="grid lg:grid-cols-3 gap-6">
                    {{-- Main Content Section --}}
                    <div class="lg:col-span-2 space-y-6">
                        {{-- Title Card --}}
                        <div
                            class="bg-white dark:bg-zinc-800 rounded-xl shadow-lg border border-zinc-200 dark:border-zinc-700 p-6 hover:shadow-xl transition-shadow">
                            <div class="flex items-center gap-3 mb-4">
                                <div class="p-2 rounded-lg bg-blue-100 dark:bg-blue-900/30">
                                    <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z">
                                        </path>
                                    </svg>
                                </div>
                                <div>
                                    <label for="title"
                                        class="block text-sm font-semibold text-zinc-900 dark:text-white">
                                        Post Title <span class="text-red-500">*</span>
                                    </label>
                                    <p class="text-xs text-zinc-500 dark:text-zinc-400">A catchy title helps attract
                                        readers</p>
                                </div>
                            </div>
                            <input type="text" id="title" name="title" value="{{ old('title') }}" required
                                placeholder="Enter an engaging post title..."
                                class="w-full px-4 py-3 text-lg border-2 border-zinc-200 dark:border-zinc-700 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-zinc-900 dark:text-white transition-all @error('title') @enderror">
                            @error('title')
                                <p class="text-red-500 text-sm mt-2 flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- Content Card with Quill --}}
                        <div
                            class="bg-white dark:bg-zinc-800 rounded-xl shadow-lg border border-zinc-200 dark:border-zinc-700 p-6 hover:shadow-xl transition-shadow">
                            <div class="flex items-center gap-3 mb-4">
                                <div class="p-2 rounded-lg bg-purple-100 dark:bg-purple-900/30">
                                    <svg class="w-5 h-5 text-purple-600 dark:text-purple-400" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                        </path>
                                    </svg>
                                </div>
                                <div>
                                    <label for="content"
                                        class="block text-sm font-semibold text-zinc-900 dark:text-white">
                                        Content <span class="text-red-500">*</span>
                                    </label>
                                    <p class="text-xs text-zinc-500 dark:text-zinc-400">Tell your story with rich
                                        formatting</p>
                                </div>
                            </div>

                            {{-- Quill Editor --}}
                            <div id="quill-editor"
                                class="bg-white dark:bg-zinc-900 rounded-lg border-2 border-zinc-200 dark:border-zinc-700 @error('content') @enderror">
                            </div>
                            <input type="hidden" name="content" id="content" value="{{ old('content') }}">

                            @error('content')
                                <p class="text-red-500 text-sm mt-2 flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- Featured Image Card --}}
                        <div
                            class="bg-white dark:bg-zinc-800 rounded-xl shadow-lg border border-zinc-200 dark:border-zinc-700 p-6 hover:shadow-xl transition-shadow">
                            <div class="flex items-center gap-3 mb-4">
                                <div class="p-2 rounded-lg bg-green-100 dark:bg-green-900/30">
                                    <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                </div>
                                <div>
                                    <label for="image"
                                        class="block text-sm font-semibold text-zinc-900 dark:text-white">
                                        Featured Image
                                    </label>
                                    <p class="text-xs text-zinc-500 dark:text-zinc-400">Add a visual appeal to your post
                                    </p>
                                </div>
                            </div>

                            <div class="relative">
                                <input type="file" id="image" name="image" accept="image/*" class="hidden">
                                <label for="image"
                                    class="flex flex-col items-center justify-center w-full h-64 border-2 border-dashed border-zinc-300 dark:border-zinc-600 rounded-lg cursor-pointer bg-zinc-50 dark:bg-zinc-900 hover:bg-zinc-100 dark:hover:bg-zinc-800 transition-colors">
                                    <div id="upload-area" class="flex flex-col items-center justify-center pt-5 pb-6">
                                        <svg class="w-12 h-12 mb-4 text-zinc-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12">
                                            </path>
                                        </svg>
                                        <p class="mb-2 text-sm text-zinc-600 dark:text-zinc-400"><span
                                                class="font-semibold">Click to upload</span> or drag and drop</p>
                                        <p class="text-xs text-zinc-500 dark:text-zinc-400">PNG, JPG, GIF, WebP (MAX.
                                            4MB)</p>
                                    </div>
                                    <div id="image-preview" class="hidden w-full h-full">
                                        <img src="" alt="Preview" class="w-full h-full object-cover rounded-lg">
                                    </div>
                                </label>
                            </div>
                            @error('image')
                                <p class="text-red-500 text-sm mt-2 flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>

                    {{-- Sidebar Section --}}
                    <div class="space-y-6">
                        {{-- Publish Card --}}
                        <div
                            class="bg-white dark:bg-zinc-800 rounded-xl shadow-lg border border-zinc-200 dark:border-zinc-700 p-6 sticky top-6">
                            <div class="flex items-center gap-3 mb-4">
                                <div class="p-2 rounded-lg bg-yellow-100 dark:bg-yellow-900/30">
                                    <svg class="w-5 h-5 text-yellow-600 dark:text-yellow-400" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <h3 class="text-sm font-semibold text-zinc-900 dark:text-white">Publishing</h3>
                            </div>

                            {{-- Status --}}
                            <div class="mb-4">
                                <label for="status"
                                    class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                                    Status <span class="text-red-500">*</span>
                                </label>
                                <select id="status" name="status" required
                                    class="w-full px-4 py-2.5 border-2 border-zinc-200 dark:border-zinc-700 rounded-lg shadow-sm focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 dark:bg-zinc-900 dark:text-white transition-all">
                                    @foreach(App\Enums\PostStatus::cases() as $status)
                                        <option value="{{ $status->value }}" {{ old('status') == $status->value ? 'selected' : '' }}>
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
                                <label for="category_id"
                                    class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                                    Category
                                </label>
                                <select name="category_id" id="category_id"
                                    class="w-full px-4 py-2.5 border-2 border-zinc-200 dark:border-zinc-700 rounded-lg shadow-sm focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 dark:bg-zinc-900 dark:text-white transition-all">
                                    <option value="">— Select category —</option>
                                    @foreach($categories as $cat)
                                        <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
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
                                <label for="tags"
                                    class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                                    Tags
                                </label>
                                <input type="text" id="tags" name="tags" value="{{ old('tags') }}"
                                    placeholder="Laravel, PHP, Web Dev..."
                                    class="w-full px-4 py-2.5 border-2 border-zinc-200 dark:border-zinc-700 rounded-lg shadow-sm focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 dark:bg-zinc-900 dark:text-white transition-all">
                                <p class="text-xs text-zinc-500 dark:text-zinc-400 mt-1.5 flex items-center gap-1">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Separate with commas
                                </p>
                                @error('tags')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Action Buttons --}}
                            <div class="space-y-3 pt-4 border-t border-zinc-200 dark:border-zinc-700">
                                <button type="submit"
                                    class="w-full flex items-center justify-center gap-2 bg-linear-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-semibold py-3 px-6 rounded-lg transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    Create Post
                                </button>
                                <a href="{{ route('posts.index') }}"
                                    class="w-full flex items-center justify-center gap-2 bg-zinc-200 hover:bg-zinc-300 dark:bg-zinc-700 dark:hover:bg-zinc-600 text-zinc-800 dark:text-white font-semibold py-3 px-6 rounded-lg transition-all duration-200">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                    Cancel
                                </a>
                            </div>

                            {{-- Tips Card --}}
                            <div
                                class="bg-linear-to-br from-blue-50 to-purple-50 dark:from-blue-900/20 dark:to-purple-900/20 rounded-xl p-6 border border-blue-200 dark:border-blue-800 mt-8">
                                <div class="flex items-center gap-2 mb-3">
                                    <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z">
                                        </path>
                                    </svg>
                                    <h4 class="font-semibold text-zinc-900 dark:text-white">Writing Tips</h4>
                                </div>
                                <ul class="space-y-2 text-sm text-zinc-700 dark:text-zinc-300">
                                    <li class="flex items-start gap-2">
                                        <svg class="w-4 h-4 text-green-600 dark:text-green-400 mt-0.5"
                                            fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                        Use engaging titles
                                    </li>
                                    <li class="flex items-start gap-2">
                                        <svg class="w-4 h-4 text-green-600 dark:text-green-400 mt-0.5"
                                            fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                        Add relevant images
                                    </li>
                                    <li class="flex items-start gap-2">
                                        <svg class="w-4 h-4 text-green-600 dark:text-green-400 mt-0.5"
                                            fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                        Use proper formatting
                                    </li>
                                    <li class="flex items-start gap-2">
                                        <svg class="w-4 h-4 text-green-600 dark:text-green-400 mt-0.5"
                                            fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                        Add descriptive tags
                                    </li>
                                </ul>
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
                        [{ 'script': 'sub' }, { 'script': 'super' }],
                        [{ 'list': 'ordered' }, { 'list': 'bullet' }],
                        [{ 'indent': '-1' }, { 'indent': '+1' }],
                        [{ 'align': [] }],
                        ['blockquote', 'code-block'],
                        ['link', 'image', 'video'],
                        ['clean']
                    ]
                },
                placeholder: 'Start writing your amazing content here...'
            });

            // Load old content if validation fails
            const oldContent = `{{ old('content') }}`;
            if (oldContent) {
                quill.root.innerHTML = oldContent;
            }

            // Update hidden input on form submit
            document.getElementById('post-form').addEventListener('submit', function (e) {
                const content = document.querySelector('#content');
                content.value = quill.root.innerHTML;

                // Validate content is not empty
                if (quill.getText().trim().length === 0) {
                    e.preventDefault();
                    alert('Please add some content to your post');
                    return false;
                }
            });

            // Auto-save content to localStorage every 30 seconds
            setInterval(() => {
                localStorage.setItem('draft_content', quill.root.innerHTML);
                localStorage.setItem('draft_title', document.getElementById('title').value);
            }, 30000);

            // Load draft on page load
            window.addEventListener('load', () => {
                const draftContent = localStorage.getItem('draft_content');
                const draftTitle = localStorage.getItem('draft_title');

                if (draftContent && !oldContent) {
                    if (confirm('Found a saved draft. Would you like to restore it?')) {
                        quill.root.innerHTML = draftContent;
                        if (draftTitle) document.getElementById('title').value = draftTitle;
                    } else {
                        localStorage.removeItem('draft_content');
                        localStorage.removeItem('draft_title');
                    }
                }
            });

            // Clear draft after successful submission
            const form = document.getElementById('post-form');
            form.addEventListener('submit', () => {
                setTimeout(() => {
                    localStorage.removeItem('draft_content');
                    localStorage.removeItem('draft_title');
                }, 1000);
            });

            // Image preview functionality
            const imageInput = document.getElementById('image');
            const uploadArea = document.getElementById('upload-area');
            const imagePreview = document.getElementById('image-preview');
            const img = imagePreview.querySelector('img');

            imageInput.addEventListener('change', function (e) {
                const file = e.target.files[0];

                if (file) {
                    const reader = new FileReader();
                    reader.onload = function (e) {
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