<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Tag;
use App\Models\Category;
use App\Enums\PostStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
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

        if ($request->filled('category')) {
            $cat = Category::where('slug', $request->category)->orWhere('id', $request->category)->first();
            if ($cat)
                $query->where('category_id', $cat->id);

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
            'tags' => 'nullable|string',
        ]);

        // Handle image upload with resize (v3 syntax)
        $imagePath = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '_' . Str::slug(pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $image->getClientOriginalExtension();
            
            // Create ImageManager with GD driver
            $manager = new Image(new Driver());
            
            // Read and resize image
            $img = $manager->read($image->getRealPath());
            $img->cover(1920, 1080); // Resize to 1920x1080 (cover = fit + crop)
            
            // Ensure directory exists
            $directory = storage_path('app/public/posts');
            if (!file_exists($directory)) {
                mkdir($directory, 0755, true);
            }
            
            // Save to storage
            $img->save($directory . '/' . $filename, quality: 85);
            $imagePath = 'posts/' . $filename;
        }

        $post = Auth::user()->posts()->create([
            'title' => $request->title,
            'content' => $request->content,
            'category_id' => $request->category_id,
            'status' => $request->status ? PostStatus::from($request->status) : PostStatus::Draft,
            'image' => $imagePath,
        ]);

        // Handle tags
        if ($request->filled('tags')) {
            $tagNames = array_map('trim', explode(',', $request->tags));
            $tagIds = [];

            foreach ($tagNames as $tagName) {
                if (!empty($tagName)) {
                    $tag = Tag::firstOrCreate(
                        ['name' => $tagName],
                        ['slug' => Str::slug($tagName)]
                    );
                    $tagIds[] = $tag->id;
                }
            }

            $post->tags()->sync($tagIds);
        }

        session()->flash('toast', [
            'variant' => 'success',
            'heading' => 'Post created successfully',
            'text' => 'Your post "' . $post->title . '" has been created',
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
            'tags' => 'nullable|string',
            'remove_image' => 'nullable|boolean',

        ]);
        $post = Auth::user()->posts()->findOrFail($id);

        // Handle image upload
        $imagePath = $post->image;
        
        // Remove image if checkbox is checked
        if ($request->has('remove_image') && $request->remove_image == '1') {
            if ($post->image && Storage::disk('public')->exists($post->image)) {
                Storage::disk('public')->delete($post->image);
            }
            $imagePath = null;
        }
        
        // Upload new image with resize (v3 syntax)
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($post->image && Storage::disk('public')->exists($post->image)) {
                Storage::disk('public')->delete($post->image);
            }
            
            $image = $request->file('image');
            $filename = time() . '_' . Str::slug(pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $image->getClientOriginalExtension();
            
            // Create ImageManager with GD driver
            $manager = new Image(new Driver());
            
            // Read and resize image
            $img = $manager->read($image->getRealPath());
            $img->cover(1920, 1080); // Resize to 1920x1080
            
            // Ensure directory exists
            $directory = storage_path('app/public/posts');
            if (!file_exists($directory)) {
                mkdir($directory, 0755, true);
            }
            
            // Save to storage
            $img->save($directory . '/' . $filename, quality: 85);
            $imagePath = 'posts/' . $filename;
        }

        $post->update([
            'title' => $request->title,
            'content' => $request->content,
            'category_id' => $request->category_id,
            'status' => $request->status ? PostStatus::from($request->status) : $post->status,
            'image' => $imagePath,
        ]);

        // Handle tags
        if ($request->filled('tags')) {
            $tagNames = array_map('trim', explode(',', $request->tags));
            $tagIds = [];

            foreach ($tagNames as $tagName) {
                if (!empty($tagName)) {
                    $tag = Tag::firstOrCreate(
                        ['name' => $tagName],
                        ['slug' => Str::slug($tagName)]
                    );
                    $tagIds[] = $tag->id;
                }
            }

            $post->tags()->sync($tagIds);
        } else {
            $post->tags()->detach();
        }

        session()->flash('toast', [
            'variant' => 'success',
            'heading' => 'Post updated successfully',
            'text' => 'Your post has been updated',
        ]);

        return redirect()->route('posts.index')->with('success', 'Post updated successfully.');
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

        session()->flash('toast', [
            'variant' => 'success',
            'heading' => 'Post deleted successfully',
        ]);

        return redirect()->route('posts.index')->with('success', 'Post deleted successfully.');
    }
}
