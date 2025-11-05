<div>
    <x-blog-header title="Contact" />

    <div class="max-w-4xl mx-auto px-6 py-12">
        <div class="prose dark:prose-invert max-w-none">
            <h1 class="text-4xl font-bold mb-6 text-gray-900 dark:text-white">Contact Us</h1>
            
            <p class="text-gray-600 dark:text-gray-400 mb-8">We'd love to hear from you. Get in touch with our team.</p>

            <div class="grid md:grid-cols-2 gap-8 mb-12">
                <!-- Contact Information -->
                <div class="space-y-6">
                    <section>
                        <h2 class="text-2xl font-semibold mb-4 text-gray-900 dark:text-white">Get In Touch</h2>
                        
                        <div class="space-y-4">
                            <div class="flex items-start gap-3">
                                <svg class="w-6 h-6 text-blue-600 dark:text-blue-400 mt-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                                <div>
                                    <h3 class="font-semibold text-gray-900 dark:text-white">Email</h3>
                                    <a href="mailto:{{ config('mail.from.address') }}" class="text-blue-600 dark:text-blue-400 hover:underline">
                                        {{ config('mail.from.address') }}
                                    </a>
                                </div>
                            </div>

                            <div class="flex items-start gap-3">
                                <svg class="w-6 h-6 text-blue-600 dark:text-blue-400 mt-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                <div>
                                    <h3 class="font-semibold text-gray-900 dark:text-white">Address</h3>
                                    <p class="text-gray-700 dark:text-gray-300">
                                        123 News Street<br>
                                        Media City, MC 12345<br>
                                        United States
                                    </p>
                                </div>
                            </div>

                            <div class="flex items-start gap-3">
                                <svg class="w-6 h-6 text-blue-600 dark:text-blue-400 mt-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                </svg>
                                <div>
                                    <h3 class="font-semibold text-gray-900 dark:text-white">Phone</h3>
                                    <p class="text-gray-700 dark:text-gray-300">+1 (555) 123-4567</p>
                                </div>
                            </div>
                        </div>
                    </section>

                    <section>
                        <h2 class="text-2xl font-semibold mb-4 text-gray-900 dark:text-white">Follow Us</h2>
                        <div class="flex gap-4">
                            <a href="#" class="p-3 bg-gray-100 dark:bg-gray-800 rounded-lg hover:bg-blue-500 hover:text-white transition-colors duration-200" aria-label="Twitter">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M23 4.6c-.8.4-1.6.7-2.5.8.9-.6 1.6-1.5 1.9-2.6-.9.6-1.9 1-3 1.2C18 3.1 16.8 2.5 15.4 2.5c-2.6 0-4.6 2.2-4.2 4.8C7.7 7 4.1 5.1 1.7 2.3c-.3.5-.4 1-.4 1.6 0 1.7.9 3.2 2.3 4.1-.7 0-1.4-.2-2-.5v.1c0 2.4 1.7 4.4 3.9 4.8-.4.1-.8.2-1.3.2-.3 0-.6 0-.9-.1.6 2 2.5 3.4 4.6 3.4-1.7 1.3-3.8 2-6.1 2-.4 0-.8 0-1.2-.1C2.7 20.3 5.9 21 9.4 21c6.9 0 10.7-5.8 10.7-10.8v-.5c.8-.6 1.5-1.3 2-2.1-.7.3-1.5.5-2.3.6z"/>
                                </svg>
                            </a>
                            <a href="#" class="p-3 bg-gray-100 dark:bg-gray-800 rounded-lg hover:bg-blue-600 hover:text-white transition-colors duration-200" aria-label="Facebook">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                </svg>
                            </a>
                            <a href="#" class="p-3 bg-gray-100 dark:bg-gray-800 rounded-lg hover:bg-pink-600 hover:text-white transition-colors duration-200" aria-label="Instagram">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M7 2h10a5 5 0 0 1 5 5v10a5 5 0 0 1-5 5H7a5 5 0 0 1-5-5V7a5 5 0 0 1 5-5zm5 6.2A3.8 3.8 0 1 0 15.8 12 3.8 3.8 0 0 0 12 8.2zM18.5 6a1 1 0 1 0 0 2 1 1 0 0 0 0-2z"/>
                                </svg>
                            </a>
                        </div>
                    </section>
                </div>

                <!-- Contact Form -->
                <div>
                    <h2 class="text-2xl font-semibold mb-4 text-gray-900 dark:text-white">Send us a Message</h2>
                    
                    @if($successMessage)
                        <div class="mb-4 p-4 bg-green-50 dark:bg-green-900/20 border border-green-500 rounded-lg animate-fade-in">
                            <div class="flex items-start gap-3">
                                <svg class="w-5 h-5 text-green-600 dark:text-green-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <p class="text-sm text-green-800 dark:text-green-200">{{ $successMessage }}</p>
                            </div>
                        </div>
                    @endif

                    @if($errorMessage)
                        <div class="mb-4 p-4 bg-red-50 dark:bg-red-900/20 border border-red-500 rounded-lg animate-fade-in">
                            <div class="flex items-start gap-3">
                                <svg class="w-5 h-5 text-red-600 dark:text-red-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <p class="text-sm text-red-800 dark:text-red-200">{{ $errorMessage }}</p>
                            </div>
                        </div>
                    @endif

                    <form wire:submit="submit" class="space-y-4">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Name <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="text" 
                                id="name" 
                                wire:model="name"
                                class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all duration-200 @error('name') @enderror"
                                placeholder="John Doe"
                            />
                            @error('name')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400 flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Email <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="email" 
                                id="email" 
                                wire:model="email"
                                class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all duration-200 @error('email') @enderror"
                                placeholder="john@example.com"
                            />
                            @error('email')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400 flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <div>
                            <label for="subject" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Subject <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="text" 
                                id="subject" 
                                wire:model="subject"
                                class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all duration-200 @error('subject') @enderror"
                                placeholder="What is this regarding?"
                            />
                            @error('subject')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400 flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <div>
                            <label for="message" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Message <span class="text-red-500">*</span>
                            </label>
                            <textarea 
                                id="message" 
                                wire:model="message"
                                rows="5" 
                                class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all duration-200 @error('message') @enderror"
                                placeholder="Your message here..."
                            ></textarea>
                            @error('message')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400 flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <button 
                            type="submit" 
                            wire:loading.attr="disabled"
                            wire:loading.class="opacity-50 cursor-not-allowed"
                            class="w-full bg-blue-600 hover:bg-blue-700 disabled:bg-blue-400 text-white py-3 rounded-lg font-semibold transition-all duration-200 shadow-md hover:shadow-lg flex items-center justify-center gap-2"
                        >
                            <span wire:loading.remove wire:target="submit">
                                <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                                Send Message
                            </span>
                            <span wire:loading wire:target="submit" class="flex items-center gap-2">
                                <svg class="animate-spin h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                Sending...
                            </span>
                        </button>
                    </form>
                </div>
            </div>

            <section class="bg-blue-50 dark:bg-blue-900/20 rounded-lg p-6">
                <h2 class="text-2xl font-semibold mb-4 text-gray-900 dark:text-white">Frequently Asked Questions</h2>
                <div class="space-y-4">
                    <details class="group">
                        <summary class="cursor-pointer font-medium text-gray-900 dark:text-white list-none flex items-center justify-between p-3 hover:bg-blue-100 dark:hover:bg-blue-900/30 rounded-lg transition-colors duration-200">
                            How can I submit a story tip?
                            <svg class="w-5 h-5 transition-transform group-open:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </summary>
                        <p class="mt-2 px-3 pb-3 text-gray-700 dark:text-gray-300">
                            You can send story tips directly to our editorial team at <a href="mailto:{{ config('mail.from.address') }}" class="text-blue-600 dark:text-blue-400 hover:underline">{{ config('mail.from.address') }}</a>
                        </p>
                    </details>
                    
                    <details class="group">
                        <summary class="cursor-pointer font-medium text-gray-900 dark:text-white list-none flex items-center justify-between p-3 hover:bg-blue-100 dark:hover:bg-blue-900/30 rounded-lg transition-colors duration-200">
                            Do you accept guest posts?
                            <svg class="w-5 h-5 transition-transform group-open:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </summary>
                        <p class="mt-2 px-3 pb-3 text-gray-700 dark:text-gray-300">
                            Yes! Please use the contact form above with the subject "Guest Post Inquiry" to discuss opportunities.
                        </p>
                    </details>
                    
                    <details class="group">
                        <summary class="cursor-pointer font-medium text-gray-900 dark:text-white list-none flex items-center justify-between p-3 hover:bg-blue-100 dark:hover:bg-blue-900/30 rounded-lg transition-colors duration-200">
                            How do I report an error?
                            <svg class="w-5 h-5 transition-transform group-open:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </summary>
                        <p class="mt-2 px-3 pb-3 text-gray-700 dark:text-gray-300">
                            We take accuracy seriously. Please email us at <a href="mailto:{{ config('mail.from.address') }}" class="text-blue-600 dark:text-blue-400 hover:underline">{{ config('mail.from.address') }}</a> with details about the error.
                        </p>
                    </details>
                </div>
            </section>
        </div>
    </div>

    <x-footer />

    @push('scripts')
    <script>
        document.addEventListener('livewire:init', () => {
            Livewire.on('scroll-to-top', () => {
                window.scrollTo({ top: 0, behavior: 'smooth' });
            });
        });
    </script>
    @endpush
</div>