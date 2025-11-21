@props([
    'title' => config('app.name'),
    'description' => 'Your trusted source for news and insights',
    'keywords' => '',
    'image' => null,
    'url' => null,
    'type' => 'website',
    'schema' => null,
    'canonical' => null,
])

{{-- Basic Meta Tags --}}
<title>{{ $title }}</title>
<meta name="description" content="{{ $description }}">
@if($keywords)
    <meta name="keywords" content="{{ $keywords }}">
@endif

{{-- Canonical URL --}}
<link rel="canonical" href="{{ $canonical ?? url()->current() }}">

{{-- Open Graph Meta Tags --}}
<meta property="og:title" content="{{ $title }}">
<meta property="og:description" content="{{ $description }}">
<meta property="og:type" content="{{ $type }}">
<meta property="og:url" content="{{ $url ?? url()->current() }}">
<meta property="og:site_name" content="{{ config('app.name') }}">
@if($image)
    <meta property="og:image" content="{{ $image }}">
    <meta property="og:image:alt" content="{{ $title }}">
@endif

{{-- Twitter Card Meta Tags --}}
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{ $title }}">
<meta name="twitter:description" content="{{ $description }}">
@if($image)
    <meta name="twitter:image" content="{{ $image }}">
@endif

{{-- Article Specific Tags --}}
@if($type === 'article' && isset($publishedTime))
    <meta property="article:published_time" content="{{ $publishedTime }}">
    <meta property="article:modified_time" content="{{ $modifiedTime }}">
    <meta property="article:author" content="{{ $author ?? '' }}">
@endif

{{-- JSON-LD Structured Data --}}
@if($schema)
    <script type="application/ld+json">
        {!! json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
    </script>
@endif

{{-- Robots Meta --}}
<meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1">