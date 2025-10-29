<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Enums\PostStatus;
use App\Models\Category;

class PublicPostController extends Controller
{
    //
    public function index(Request $request){
        $query = Post::with('user', 'category')->where('status', PostStatus::Published)->latest();

        if($request->has('search') && $request->search){
            $query->where('title', 'like', '%' . $request->search . '%')->orWhere('content', 'like', '%' . $request->search . '%');
        }

        if($request->has('category') && $request->category){
            $category = Category::where('slug', $request->category)->first();
            if($category){
                $query->where('category_id', $category->id);
            }
        }

        $posts = $query->paginate(12);
        $categories = Category::orderBy('name')->get();
        return view('posts.public', compact('posts', 'categories'));
    }

    public function show($id){
        $post = Post::with('user', 'category')->where('status', PostStatus::Published)->findOrFail($id);
        return view('posts.show', compact('post'));
    }
}
