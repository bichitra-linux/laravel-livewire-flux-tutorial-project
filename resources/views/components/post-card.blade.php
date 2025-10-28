<div {{ $attributes->merge(['class' => 'post-card bg-white dark:bg-gray-800 p-4 rounded shadow']) }}>
    <h3>{{ $post->title }}</h3>
    <p>{{ Str::limit($post->content, 100) }}</p>
    <small>{{ $post->created_at->format('M d, Y') }}</small>
    <a href="{{ route('posts.show', $post) }}">Read More</a>
    {{ $slot }}
</div>