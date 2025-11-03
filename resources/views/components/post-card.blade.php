@props(['post'])

<div {{ $attributes->merge(['class' => 'post-card bg-white dark:bg-gray-800 rounded-xl shadow-md hover:shadow-xl transition-all duration-300 overflow-hidden']) }}>
    {{-- Post Image --}}
    @if($post->image)
        <div class="h-48 bg-cover bg-center" 
            style="background-image: url('{{ asset('storage/' . $post->image) }}')">
        </div>
    @else
        <div class="h-48 bg-gradient-to-br from-gray-200 to-gray-300 dark:from-gray-700 dark:to-gray-800 flex items-center justify-center">
            <svg class="w-16 h-16 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
            </svg>
        </div>
    @endif

    <div class="p-5">
        {{-- Metadata --}}
        <div class="flex items-center gap-2 text-xs text-gray-500 dark:text-gray-400 mb-3">
            <span>{{ $post->created_at->format('M d, Y') }}</span>
            @if($post->category)
                <span>•</span>
                <span class="bg-blue-100 dark:bg-blue-900 text-blue-700 dark:text-blue-300 px-2 py-0.5 rounded-full">
                    {{ $post->category->name }}
                </span>
            @endif
        </div>

        {{-- Title --}}
        <h3 class="font-bold text-xl text-gray-900 dark:text-white mb-2 line-clamp-2 hover:text-blue-600 dark:hover:text-blue-400 transition-colors">
            <a href="{{ route('posts.show', $post) }}">
                {{ $post->title }}
            </a>
        </h3>

        {{-- Excerpt --}}
        <p class="text-sm text-gray-600 dark:text-gray-400 line-clamp-3 mb-4">
            {{ Str::limit(strip_tags($post->content), 120) }}
        </p>

        {{-- Footer --}}
        <div class="flex items-center justify-between pt-3 border-t border-gray-200 dark:border-gray-700">
            <a href="{{ route('posts.show', $post) }}" 
                class="text-sm font-semibold text-blue-600 dark:text-blue-400 hover:underline">
                Read More →
            </a>

            {{-- Compact Reactions --}}
            @if($post->reactions->count() > 0)
                <x-post-reactions :post="$post" :compact="true" />
            @endif
        </div>

        {{ $slot }}
    </div>
</div>