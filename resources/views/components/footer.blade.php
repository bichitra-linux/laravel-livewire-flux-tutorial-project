<footer class="bg-gray-800 text-white py-8 mt-auto flex-shrink-0" role="contentinfo">
    <div class="max-w-7xl mx-auto px-6">
        <div class="grid gap-8 md:grid-cols-3">
            <div>
                <h3 class="text-lg font-semibold mb-4">About Us</h3>
                <p class="text-sm text-gray-300">Learn more about our mission and values.</p>
            </div>

            <nav aria-label="Quick links" class="flex items-start">
                <div>
                    <h3 class="text-lg font-semibold mb-4">Quick Links</h3>
                    <ul class="space-y-2 text-sm">
                        <li><a href="{{ route('home') }}" class="text-gray-300 hover:text-white hover:underline">Home</a></li>
                        <li><a href="{{ route('posts.index') }}" class="text-gray-300 hover:text-white hover:underline">Posts</a></li>
                        <li><a href="{{  '#' }}" class="text-gray-300 hover:text-white hover:underline">Contact</a></li>
                    </ul>
                </div>
            </nav>

            <div>
                <h3 class="text-lg font-semibold mb-4">Follow Us</h3>
                <div class="flex items-center space-x-4">
                    <a href="#" class="text-gray-300 hover:text-white" aria-label="GitHub">
                        <!-- simple svg icon -->
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path d="M12 .5A12 12 0 0 0 0 12.5C0 17.8 3.4 22 8.2 23.5c.6.1.8-.2.8-.5v-2c-3.3.7-4-1.6-4-1.6-.5-1.3-1.2-1.6-1.2-1.6-1-.7.1-.7.1-.7 1.1.1 1.6 1.1 1.6 1.1 1 .1 1.6-.7 1.8-1.1.2-.6.7-1 .9-1.2-2.6-.3-5.3-1.3-5.3-5.8 0-1.3.5-2.3 1.2-3.1-.1-.3-.5-1.5.1-3.1 0 0 1-.3 3.3 1.2a11.3 11.3 0 0 1 6 0C18.3 3 19.3 3.3 19.3 3.3c.6 1.6.2 2.8.1 3.1.8.8 1.2 1.8 1.2 3.1 0 4.5-2.7 5.5-5.3 5.8.7.6 1.2 1.5 1.2 3v4.4c0 .3.2.6.8.5A12 12 0 0 0 24 12.5 12 12 0 0 0 12 .5z"/></svg>
                    </a>

                    <a href="#" class="text-gray-300 hover:text-white" aria-label="Twitter">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path d="M23 4.6c-.8.4-1.6.7-2.5.8.9-.6 1.6-1.5 1.9-2.6-.9.6-1.9 1-3 1.2C18 3.1 16.8 2.5 15.4 2.5c-2.6 0-4.6 2.2-4.2 4.8C7.7 7 4.1 5.1 1.7 2.3c-.3.5-.4 1-.4 1.6 0 1.7.9 3.2 2.3 4.1-.7 0-1.4-.2-2-.5v.1c0 2.4 1.7 4.4 3.9 4.8-.4.1-.8.2-1.3.2-.3 0-.6 0-.9-.1.6 2 2.5 3.4 4.6 3.4-1.7 1.3-3.8 2-6.1 2-.4 0-.8 0-1.2-.1C2.7 20.3 5.9 21 9.4 21c6.9 0 10.7-5.8 10.7-10.8v-.5c.8-.6 1.5-1.3 2-2.1-.7.3-1.5.5-2.3.6z"/></svg>
                    </a>

                    <a href="#" class="text-gray-300 hover:text-white" aria-label="Instagram">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path d="M7 2h10a5 5 0 0 1 5 5v10a5 5 0 0 1-5 5H7a5 5 0 0 1-5-5V7a5 5 0 0 1 5-5zm5 6.2A3.8 3.8 0 1 0 15.8 12 3.8 3.8 0 0 0 12 8.2zM18.5 6a1 1 0 1 0 0 2 1 1 0 0 0 0-2z"/></svg>
                    </a>
                </div>
            </div>
        </div>

        <div class="border-t border-gray-700 mt-8 pt-6 text-center">
            <p class="text-sm text-gray-400">&copy; {{ date('Y') }} Blog. All rights reserved.</p>
        </div>
    </div>
</footer>