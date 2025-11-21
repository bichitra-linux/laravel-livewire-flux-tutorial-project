@props(['items' => []])

<nav class="bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 py-4">
    <div class="max-w-7xl mx-auto px-6">
        <ol class="flex items-center space-x-2 text-sm">
            @foreach($items as $index => $item)
                <li class="flex items-center">
                    @if($index > 0)
                        <svg class="w-4 h-4 text-gray-400 dark:text-gray-500 mx-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                        </svg>
                    @endif

                    @if($item['url'])
                        <a href="{{ $item['url'] }}" 
                           class="text-gray-600 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 font-medium transition-colors duration-200">
                            {{ $item['label'] }}
                        </a>
                    @else
                        <span class="text-gray-900 dark:text-white font-semibold">
                            {{ $item['label'] }}
                        </span>
                    @endif
                </li>
            @endforeach
        </ol>
    </div>
</nav>