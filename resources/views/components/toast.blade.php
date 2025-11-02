@props([
    'variant' => 'info', // success, error, warning, info
    'heading' => '',
    'text' => '',
])

@php
    $variants = [
        'success' => [
            'bg' => 'bg-green-50 dark:bg-green-900/20',
            'border' => 'border-green-200 dark:border-green-800',
            'icon' => 'text-green-600 dark:text-green-400',
            'heading' => 'text-green-900 dark:text-green-100',
            'text' => 'text-green-700 dark:text-green-300',
            'icon_svg' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>',
        ],
        'error' => [
            'bg' => 'bg-red-50 dark:bg-red-900/20',
            'border' => 'border-red-200 dark:border-red-800',
            'icon' => 'text-red-600 dark:text-red-400',
            'heading' => 'text-red-900 dark:text-red-100',
            'text' => 'text-red-700 dark:text-red-300',
            'icon_svg' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>',
        ],
        'warning' => [
            'bg' => 'bg-yellow-50 dark:bg-yellow-900/20',
            'border' => 'border-yellow-200 dark:border-yellow-800',
            'icon' => 'text-yellow-600 dark:text-yellow-400',
            'heading' => 'text-yellow-900 dark:text-yellow-100',
            'text' => 'text-yellow-700 dark:text-yellow-300',
            'icon_svg' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>',
        ],
        'info' => [
            'bg' => 'bg-blue-50 dark:bg-blue-900/20',
            'border' => 'border-blue-200 dark:border-blue-800',
            'icon' => 'text-blue-600 dark:text-blue-400',
            'heading' => 'text-blue-900 dark:text-blue-100',
            'text' => 'text-blue-700 dark:text-blue-300',
            'icon_svg' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>',
        ],
    ];

    $config = $variants[$variant] ?? $variants['info'];
@endphp

<div
    x-data="{ show: true }"
    x-show="show"
    x-init="setTimeout(() => show = false, 5000)"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0 transform translate-y-2"
    x-transition:enter-end="opacity-100 transform translate-y-0"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100 transform translate-y-0"
    x-transition:leave-end="opacity-0 transform translate-y-2"
    class="fixed bottom-4 right-4 z-50 max-w-sm w-full shadow-lg rounded-lg border {{ $config['bg'] }} {{ $config['border'] }} p-4"
    role="alert"
>
    <div class="flex items-start">
        {{-- Icon --}}
        <div class="flex-shrink-0">
            <svg class="h-6 w-6 {{ $config['icon'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                {!! $config['icon_svg'] !!}
            </svg>
        </div>

        {{-- Content --}}
        <div class="ml-3 flex-1">
            @if($heading)
                <h3 class="text-sm font-medium {{ $config['heading'] }}">
                    {{ $heading }}
                </h3>
            @endif
            
            @if($text)
                <p class="mt-1 text-sm {{ $config['text'] }}">
                    {{ $text }}
                </p>
            @endif
        </div>

        {{-- Close Button --}}
        <div class="ml-4 flex-shrink-0 flex">
            <button
                @click="show = false"
                class="inline-flex rounded-md {{ $config['icon'] }} hover:opacity-75 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-{{ explode('-', $config['icon'])[1] }}-500"
            >
                <span class="sr-only">Close</span>
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
    </div>
</div>