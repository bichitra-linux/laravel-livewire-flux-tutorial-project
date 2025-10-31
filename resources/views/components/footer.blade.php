<footer class="bg-gradient-to-r from-gray-800 to-gray-900 text-white py-12 mt-auto flex-shrink-0 shadow-lg" role="contentinfo">
    <div class="max-w-7xl mx-auto px-6">
        <div class="grid gap-8 lg:grid-cols-4 md:grid-cols-2">
            <div>
                <h3 class="text-lg font-semibold mb-4 text-white">About Us</h3>
                <p class="text-sm text-gray-300 leading-relaxed">Learn more about our mission and values.</p>
            </div>

            <nav aria-label="Quick links" class="flex items-start">
                <div>
                    <h3 class="text-lg font-semibold mb-4 text-white">Quick Links</h3>
                    <ul class="space-y-2 text-sm">
                        <li><a href="{{ route('home') }}" class="text-gray-300 hover:text-blue-400 hover:underline transition-colors duration-200">Home</a></li>
                        <li><a href="{{ route('public.posts.index') }}" class="text-gray-300 hover:text-blue-400 hover:underline transition-colors duration-200">Posts</a></li>
                        <li><a href="{{  '#' }}" class="text-gray-300 hover:text-blue-400 hover:underline transition-colors duration-200">Contact</a></li>
                    </ul>
                </div>
            </nav>

            <div>
                <h3 class="text-lg font-semibold mb-4 text-white">Follow Us</h3>
                <div class="flex items-center space-x-4">
                    <a href="#" class="text-gray-300 hover:text-blue-400 transition-all duration-200 transform hover:scale-110" aria-label="GitHub">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path d="M12 .5A12 12 0 0 0 0 12.5C0 17.8 3.4 22 8.2 23.5c.6.1.8-.2.8-.5v-2c-3.3.7-4-1.6-4-1.6-.5-1.3-1.2-1.6-1.2-1.6-1-.7.1-.7.1-.7 1.1.1 1.6 1.1 1.6 1.1 1 .1 1.6-.7 1.8-1.1.2-.6.7-1 .9-1.2-2.6-.3-5.3-1.3-5.3-5.8 0-1.3.5-2.3 1.2-3.1-.1-.3-.5-1.5.1-3.1 0 0 1-.3 3.3 1.2a11.3 11.3 0 0 1 6 0C18.3 3 19.3 3.3 19.3 3.3c.6 1.6.2 2.8.1 3.1.8.8 1.2 1.8 1.2 3.1 0 4.5-2.7 5.5-5.3 5.8.7.6 1.2 1.5 1.2 3v4.4c0 .3.2.6.8.5A12 12 0 0 0 24 12.5 12 12 0 0 0 12 .5z"/></svg>
                    </a>
                    <a href="#" class="text-gray-300 hover:text-blue-400 transition-all duration-200 transform hover:scale-110" aria-label="Twitter">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path d="M23 4.6c-.8.4-1.6.7-2.5.8.9-.6 1.6-1.5 1.9-2.6-.9.6-1.9 1-3 1.2C18 3.1 16.8 2.5 15.4 2.5c-2.6 0-4.6 2.2-4.2 4.8C7.7 7 4.1 5.1 1.7 2.3c-.3.5-.4 1-.4 1.6 0 1.7.9 3.2 2.3 4.1-.7 0-1.4-.2-2-.5v.1c0 2.4 1.7 4.4 3.9 4.8-.4.1-.8.2-1.3.2-.3 0-.6 0-.9-.1.6 2 2.5 3.4 4.6 3.4-1.7 1.3-3.8 2-6.1 2-.4 0-.8 0-1.2-.1C2.7 20.3 5.9 21 9.4 21c6.9 0 10.7-5.8 10.7-10.8v-.5c.8-.6 1.5-1.3 2-2.1-.7.3-1.5.5-2.3.6z"/></svg>
                    </a>
                    <a href="#" class="text-gray-300 hover:text-blue-400 transition-all duration-200 transform hover:scale-110" aria-label="Instagram">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path d="M7 2h10a5 5 0 0 1 5 5v10a5 5 0 0 1-5 5H7a5 5 0 0 1-5-5V7a5 5 0 0 1 5-5zm5 6.2A3.8 3.8 0 1 0 15.8 12 3.8 3.8 0 0 0 12 8.2zM18.5 6a1 1 0 1 0 0 2 1 1 0 0 0 0-2z"/></svg>
                    </a>
                </div>
            </div>

            <div>
                <h3 class="text-lg font-semibold mb-4 text-white">Newsletter</h3>
                <p class="text-sm text-gray-300 mb-4">Subscribe for the latest updates.</p>
                
                @if(session('newsletter_success'))
                    <div class="mb-3 p-3 bg-green-500/20 border border-green-500 rounded-lg">
                        <p class="text-sm text-green-200">{{ session('newsletter_success') }}</p>
                    </div>
                @endif

                @if(session('newsletter_error'))
                    <div class="mb-3 p-3 bg-red-500/20 border border-red-500 rounded-lg">
                        <p class="text-sm text-red-200">{{ session('newsletter_error') }}</p>
                    </div>
                @endif

                @if(session('newsletter_info'))
                    <div class="mb-3 p-3 bg-blue-500/20 border border-blue-500 rounded-lg">
                        <p class="text-sm text-blue-200">{{ session('newsletter_info') }}</p>
                    </div>
                @endif

                <form action="{{ route('newsletter.subscribe') }}" method="POST" class="space-y-3">
                    @csrf
                    <input 
                        type="email" 
                        name="email" 
                        placeholder="Your email" 
                        required 
                        class="w-full px-3 py-2 rounded-lg bg-gray-700 text-white border border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all duration-200 @error('email') @enderror" 
                    />
                    @error('email')
                        <p class="text-xs text-red-400">{{ $message }}</p>
                    @enderror
                    
                    <button 
                        type="submit" 
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 rounded-lg font-semibold transition-all duration-200 flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        Subscribe
                    </button>
                </form>
            </div>
        </div>

        <div class="border-t border-gray-700 mt-8 pt-6 text-center">
            <p class="text-sm text-gray-400">&copy; {{ date('Y') }} The Brief. All rights reserved.</p>
        </div>
    </div>
</footer>