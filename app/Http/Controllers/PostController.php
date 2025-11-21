<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Tag;
use App\Models\Category;
use App\Enums\PostStatus;
use App\Services\ImageOptimizationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Services\CacheService;
use Intervention\Image\ImageManager as Image;
use Intervention\Image\Drivers\Gd\Driver;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Post::with('user', 'category', 'tags')->latestPosts();

        $selectedCategory = null;
        if ($request->filled('category')) {
            // Separate queries based on whether value is numeric
            if (is_numeric($request->category)) {
                // If numeric, it could be either id or slug like "123"
                $selectedCategory = Category::where('id', $request->category)->first();

                // If not found by id, try slug
                if (!$selectedCategory) {
                    $selectedCategory = Category::where('slug', $request->category)->first();
                }
            } else {
                // If string, only search by slug
                $selectedCategory = Category::where('slug', $request->category)->first();
            }

            if ($selectedCategory) {
                $query->where('category_id', $selectedCategory->id);
            }
        }

        $posts = $query->paginate(10);

        return view('posts.index', compact('posts', 'selectedCategory'));
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
    public function store(Request $request, ImageOptimizationService $imageService)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => [
                'nullable',
                'image',
                'mimes:jpeg,png,jpg,webp',
                'max:5120', // 5MB
                'dimensions:min_width=100,min_height=100,max_width=4000,max_height=4000'
            ],
            'category_id' => 'required|exists:categories,id',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
            'status' => 'required|in:draft,published,archived',
        ]);

        // Handle image upload with resize (v3 syntax)
        $imagePath = null;
        if ($request->hasFile('image')) {
            $validated['image'] = $imageService->optimizeAndSave(
                $request->file('image'),
                'posts',
                1200
            );
        }

        $post = Auth::user()->posts()->create($validated);

        // Handle tags
        if (isset($validated['tags'])) {
            $post->tags()->attach($validated['tags']);
        }

        return redirect()->route('posts.index')
            ->with('success', 'Post created successfully!');
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

        // ✅ Use CacheService for popular posts
        $popular = CacheService::getPopularPosts(5);

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
        $post = Auth::user()->posts()->findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => [
                'nullable',
                'image',
                'mimes:jpeg,png,jpg,webp',
                'max:5120',
                'dimensions:min_width=100,min_height=100,max_width=4000,max_height=4000'
            ],
            'category_id' => 'required|exists:categories,id',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
            'status' => 'required|in:draft,published,archived',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($post->image && \Storage::disk('public')->exists($post->image)) {
                \Storage::disk('public')->delete($post->image);
            }

            $file = $request->file('image');
            $filename = Str::random(40) . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('posts', $filename, 'public');
            $validated['image'] = 'posts/' . $filename;
        }

        $post->update($validated);

        if (isset($validated['tags'])) {
            $post->tags()->sync($validated['tags']);
        }

        return redirect()->route('posts.index')
            ->with('success', 'Post updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $post = Auth::user()->posts()->findOrFail($id);

        // Delete image if exists
        if ($post->image && Storage::disk('public')->exists($post->image)) {
            Storage::disk('public')->delete($post->image);
        }

        $post->delete();
        CacheService::clearPostCache();

        session()->flash('toast', [
            'variant' => 'success',
            'heading' => 'Post deleted successfully',
        ]);

        return redirect()->route('posts.index')->with('success', 'Post deleted successfully.');
    }
}
