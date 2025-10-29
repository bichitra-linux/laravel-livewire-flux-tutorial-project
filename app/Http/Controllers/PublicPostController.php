<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Enums\PostStatus;
use App\Models\Category;

class PublicPostController extends Controller
{
    //
    public function index(Request $request)
    {
        $query = Post::with('user', 'category')->where('status', PostStatus::Published);

        // Handle search (grouped to avoid interfering with other filters)
        if ($request->has('search') && $request->search) {
            $query->where(function($q) use ($request) {
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

        // Handle sorting
        $sort = $request->get('sort', 'newest');
        switch ($sort) {
            case 'oldest':
                $query->orderBy('created_at', 'asc');
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

    public function show($id)
    {
    $post = Post::with('user', 'category')
        ->where('status', PostStatus::Published)
        ->findOrFail($id);

    // Related posts (same category, exclude current)
    $related = Post::with('user', 'category')
        ->where('status', PostStatus::Published)
        ->where('id', '!=', $post->id)
        ->when($post->category, fn($q) => $q->where('category_id', $post->category->id))
        ->latest()
        ->take(4)
        ->get();

    // Popular posts (latest 5 published)
    $popular = Post::where('status', PostStatus::Published)
        ->latest()
        ->take(5)
        ->get();

    return view('posts.show', compact('post', 'related', 'popular'));
}
}
