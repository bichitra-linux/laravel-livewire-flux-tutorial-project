<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Tag;
use App\Enums\PostStatus;
use App\Models\Category;
use Illuminate\Support\Facades\Cookie;

class PublicPostController extends Controller
{
    //
    public function index(Request $request)
    {
        $query = Post::with('user', 'category', 'tags', 'reactions')->where('status', PostStatus::Published);

        // Handle search (grouped to avoid interfering with other filters)
        if ($request->has('search') && $request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                    ->orWhere('content', 'like', '%' . $request->search . '%');
            });
        }

        // Handle category filter
        if ($request->has('category') && $request->category) {
            $category = Category::where('slug', $request->category)->first();
            if ($category) {
                $query->where('category_id', $category->id);
            }
        }

        // Handle tag filter (NEW)
        if ($request->has('tag') && $request->tag) {
            $tag = Tag::where('slug', $request->tag)->first();
            if ($tag) {
                $query->whereHas('tags', function ($q) use ($tag) {
                    $q->where('tags.id', $tag->id);
                });
            }
        }

        // Handle sorting
        $sort = $request->get('sort', 'newest');
        switch ($sort) {
            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;
            case 'most_viewed':
                $query->orderBy('views', 'desc');
                break;
            case 'title_asc':
                $query->orderBy('title', 'asc');
                break;
            case 'title_desc':
                $query->orderBy('title', 'desc');
                break;
            default:
                $query->latest();  // Newest by default
        }

        $posts = $query->paginate(12);
        $categories = Category::orderBy('name')->get();
        return view('posts.public', compact('posts', 'categories'));
    }

    public function show(Post $post)
    {
        // Check if post was soft deleted (if using soft deletes)
        if ($post->trashed()) {
            abort(410, 'This post has been permanently removed.');
        }

        // Check if post is published
        if ($post->status !== PostStatus::Published) {
            abort(404, 'This post is not available.');
        }

        // Load relationships
        $post->load('user', 'category', 'tags', 'reactions');

        // Track view with cookie to prevent multiple counts from same user
        $cookieName = 'post_' . $post->id . '_viewed';

        if (!Cookie::has($cookieName)) {
            $post->incrementViews();
            Cookie::queue($cookieName, true, 60 * 24); // 24 hours
        }

        // Related posts (same category, exclude current)
        $related = Post::with('user', 'category', 'tags', 'reactions')
            ->where('status', PostStatus::Published)
            ->where('id', '!=', $post->id)
            ->when($post->category, fn($q) => $q->where('category_id', $post->category->id))
            ->latest()
            ->take(4)
            ->get();

        // Popular posts (latest 5 published)
        $popular = Post::with('reactions')
            ->where('status', PostStatus::Published)
            ->orderBy('views', 'desc')
            ->take(5)
            ->get();

        return view('posts.show', compact('post', 'related', 'popular'));
    }
}
