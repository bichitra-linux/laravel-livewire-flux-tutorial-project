<x-blog-header>
    <div class="min-h-screen flex items-center justify-center bg-gray-50 dark:bg-gray-900 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8">
            <div class="text-center">
                {{-- Warning Icon --}}
                <div class="mx-auto flex items-center justify-center h-24 w-24 rounded-full bg-yellow-100 dark:bg-yellow-900/30">
                    <svg class="h-16 w-16 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                </div>

                {{-- Heading --}}
                <h2 class="mt-6 text-3xl font-extrabold text-gray-900 dark:text-white">
                    Already Unsubscribed
                </h2>
                <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                    This email was already unsubscribed from our newsletter.
                </p>

                {{-- Details Card --}}
                <div class="mt-6 bg-white dark:bg-gray-800 rounded-lg p-6 shadow-lg border border-gray-200 dark:border-gray-700">
                    <div class="space-y-2">
                        <p class="text-gray-700 dark:text-gray-300">
                            <strong class="font-semibold">Email:</strong> 
                            <span class="text-gray-600 dark:text-gray-400">{{ $subscriber->email }}</span>
                        </p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            Previously unsubscribed on: {{ $subscriber->unsubscribed_at?->format('M d, Y \a\t H:i') ?? 'N/A' }}
                        </p>
                    </div>
                </div>

                {{-- Actions --}}
                <div class="mt-6 space-y-3">
                    <a href="{{ route('home') }}" 
                        class="inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-lg text-white bg-blue-600 hover:bg-blue-700 transition-colors duration-200 shadow-sm">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                        Return to Homepage
                    </a>
                    
                    {{-- Resubscribe Option --}}
                    <div class="text-sm">
                        <p class="text-gray-600 dark:text-gray-400">Want to hear from us again?</p>
                        <form action="{{ route('newsletter.subscribe') }}" method="POST" class="inline mt-1">
                            @csrf
                            <input type="hidden" name="email" value="{{ $subscriber->email }}">
                            <button type="submit" class="text-blue-600 dark:text-blue-400 hover:underline font-medium">
                                Resubscribe to our newsletter
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-blog-header>
<x-footer />