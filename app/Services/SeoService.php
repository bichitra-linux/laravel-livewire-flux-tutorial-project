<?php 

namespace App\Services;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Support\Facades\Cache;

class SeoService {
    public static function getPostMeta(Post $post) {
        return [
            'title' => $post->title . '|' . config('app.name'),
            'description' => self::generateDescription($post),
            'keywords' => self::generateKeywords($post),
            'og_title' => $post->title,
            'og_description' => self::generateDescription($post),
            'og_image' => $post->image ? asset('storage/' . $post->image) : asset('images/default-og-image.jpg'),
            'og_url' => route('public.posts.show', $post->slug),
            'og_type' => 'article',
            'article_published_time' => $post->created_at->toIso8601String(),
            'article_modified_time' => $post->updated_at->toIso8601String(),
            'article_author' => $post->user->name,
            'twitter_card' => 'summary_large_image',
            'canonical' => route('public.posts.show', $post->slug),
        ];
    }

    public static function getCategoryMeta(Category $category) {
        return [
            'title' => $category->name . ' - Articles & News | ' . config('app.name'),
            'description' => "Browse articles and news in the {$category->name} category. Stay updated with the latest trends and insights.",
            'keywords' => $category->name . ', articles, news, updates',
            'canonical' => route('public.posts.index', ['category' => $category->slug]),
        ];

    }

    private static function generateDescription(Post $post) {
        $content = strip_tags($post->content);
        $content = preg_replace('/\s+/', ' ', $content);
        return mb_substr($content, 0, 155) . '...';
    }


    private static function generateKeywords(Post $post) {
        $keywords = [];

        if ($post->category) {
            $keywords[] = $post->category->name;
        }

        foreach ($post->tags as $tag) {
            $keywords[] = $tag->name;
        }

        return implode(', ', array_slice($keywords, 0, 10));
    }


    public static function getPostSchema(Post $post) {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'Article',
            'headline' => $post->title,
            'description' => self::generateDescription($post),
            'image' => $post->image ? asset('storage/' . $post->image) : null,
            'datePublished' => $post->created_at->toIso8601String(),
            'dateModified' => $post->updated_at->toIso8601String(),
            'author' => [
                '@type' => 'Person',
                'name' => $post->user->name,
            ],
            'publisher' => [
                '@type' => 'Organization',
                'name' => config('app.name'),
                'logo' => [
                    '@type' => 'ImageObject',
                    'url' => asset('images/logo.png'),
                ],
            ],
            'mainEntityOfPage' => [
                '@type' => 'WebPage',
                '@id' => route('public.posts.show', $post->slug),
            ],
        ];
    }
}