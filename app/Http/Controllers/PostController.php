<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use App\Enums\PostStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Post::with('user', 'category')->latestPosts();

        if ($request->filled('category')) {
            $cat = Category::where('slug', $request->category)->orWhere('id', $request->category)->first();
            if ($cat) $query->where('category_id', $cat->id);

        }
        $posts = $query->paginate(10);
        return view('posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::orderBy('name')->get();
        return view('posts.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category_id' => 'nullable|exists:categories,id',
            'status' => 'required|in:draft,published,archived',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('posts', 'public');
        }

        Auth::user()->posts()->create([
            'title' => $request->title,
            'content' => $request->content,
            'category_id' => $request->category_id,
            'status' => $request->status ? PostStatus::from($request->status) : PostStatus::Draft,
            'image' => $imagePath,
        ]);

        return redirect()->route('posts.index')->with('success', 'Post created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $post = Auth::user()->posts()->findOrFail($id);

        // Related posts (same category, exclude current, published only)
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

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $post = Auth::user()->posts()->findOrFail($id);
        $categories = Category::orderBy('name')->get();
        return view('posts.edit', compact('post', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category_id' => 'nullable|exists:categories,id',
            'status' => 'required|in:draft,published,archived',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',

        ]);
        $post = Auth::user()->posts()->findOrFail($id);

        $imagePath = $post->image;  // Keep existing if no new upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($post->image && Storage::disk('public')->exists($post->image)) {
                Storage::disk('public')->delete($post->image);
            }
            $imagePath = $request->file('image')->store('images', 'public');
        }

        $post->update([
            'title' => $request->title,
            'content' => $request->content,
            'category_id' => $request->category_id,
            'status' => $request->status ? PostStatus::from($request->status) : $post->status,
            'image' => $imagePath,  
        ]);

        return redirect()->route('posts.index')->with('success', 'Post updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $post = Auth::user()->posts()->findOrFail($id);
        $post->delete();

        return redirect()->route('posts.index')->with('success', 'Post deleted successfully.');
    }
}
