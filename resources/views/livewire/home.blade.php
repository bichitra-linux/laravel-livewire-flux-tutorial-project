<div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 dark:from-gray-900 dark:to-gray-800">
    <!-- Hero Section -->
    <div class="py-20 px-6 text-center">
        <div class="max-w-4xl mx-auto">
            <h1 class="text-5xl font-bold text-gray-900 dark:text-white mb-6">Welcome to the Blog</h1>
            <p class="text-xl text-gray-600 dark:text-gray-300 mb-8">Your one-stop destination for all things blogging.</p>
            <div class="flex justify-center space-x-4">
                <a href="#features" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 px-6 rounded-lg transition">Explore Features</a>
                <a href="#posts" class="bg-white border border-blue-600 text-blue-600 font-medium py-3 px-6 rounded-lg hover:bg-blue-50 transition">Read Posts</a>
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <section id="features" class="py-16 bg-white dark:bg-gray-800">
        <div class="max-w-6xl mx-auto px-6">
            <h2 class="text-3xl font-bold text-center text-gray-900 dark:text-white mb-12">Features</h2>
            <div class="grid md:grid-cols-3 gap-8">
                <div class="p-6 rounded-lg bg-white dark:bg-gray-900 shadow text-center">
                    <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-blue-100 flex items-center justify-center">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Easy to Use</h3>
                    <p class="text-gray-600 dark:text-gray-300">Our platform is designed for simplicity and ease of use.</p>
                </div>

                <div class="p-6 rounded-lg bg-white dark:bg-gray-900 shadow text-center">
                    <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-green-100 flex items-center justify-center">
                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2z"/></svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Secure & Private</h3>
                    <p class="text-gray-600 dark:text-gray-300">Authentication and data protection built-in.</p>
                </div>

                <div class="p-6 rounded-lg bg-white dark:bg-gray-900 shadow text-center">
                    <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-purple-100 flex items-center justify-center">
                        <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636"/></svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Interactive</h3>
                    <p class="text-gray-600 dark:text-gray-300">Livewire powers real-time interactions.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Posts Section -->
    <section id="posts" class="py-16 bg-gray-50 dark:bg-gray-900">
        <div class="max-w-4xl mx-auto px-6">
            <h2 class="text-3xl font-bold text-center text-gray-900 dark:text-white mb-6">Latest Posts</h2>
            @if($posts->isEmpty())
                <p class="text-gray-600 dark:text-gray-300">No posts available at the moment.</p>
            @else
                <div class="">
                    @foreach($posts as $post)
                    <x-post-card :post="$post" class="mb-6"/>
                    @endforeach
                </div>
                <div>
                    <a href="{{ route('posts.index') }}" class="text-blue-600 hover:underline">View All Posts</a>
                </div>
            @endif
        </div>
    </section>

    <!-- Newsletter Section -->
    <section class="py-16 bg-blue-600 text-white">
        <div class="max-w-4xl mx-auto px-6 text-center">
            <h2 class="text-3xl font-bold mb-4">Subscribe to our Newsletter</h2>
            <p class="text-xl mb-8">Stay updated with the latest posts and features.</p>
            <form class="flex justify-center gap-4">
                <input type="email" name="email" placeholder="Enter your email" required class="py-3 px-4 rounded-lg text-gray-900 dark:text-gray-100 bg-white dark:bg-gray-800" />
                <button type="submit" class="bg-white text-blue-600 font-medium py-3 px-6 rounded-lg hover:bg-gray-100 transition">Subscribe</button>
            </form>
        </div>
    </section>
</div>
