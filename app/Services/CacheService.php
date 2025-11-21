<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use App\Models\Post;
use App\Models\Category;
use App\Enums\PostStatus;

class CacheService
{
    const CACHE_TIME = 3600; // 1 hour

    public static function getFeaturedPosts(int $limit = 5)
    {
        return Cache::remember('posts.featured.' . $limit, self::CACHE_TIME, function () use ($limit) {
            return Post::with('user', 'category', 'tags')
                ->where('status', PostStatus::Published)
                ->whereHas('tags', fn($q) => $q->where('slug', 'featured'))
                ->latest()
                ->take($limit)
                ->get();
        });
    }

    public static function getPopularPosts(int $limit = 5)
    {
        return Cache::remember('posts.popular.' . $limit, self::CACHE_TIME, function () use ($limit) {
            return Post::with('user', 'category')
                ->where('status', PostStatus::Published)
                ->orderBy('views', 'desc')
                ->take($limit)
                ->get();
        });
    }

    public static function getCategories()
    {
        return Cache::remember('categories.all', self::CACHE_TIME, function () {
            return Category::withCount('posts')
                ->orderBy('name')
                ->get();
        });
    }

    public static function clearPostCache()
    {
        Cache::forget('posts.featured.5');
        Cache::forget('posts.popular.5');
        
    }
}