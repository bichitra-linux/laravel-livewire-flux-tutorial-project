<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Enums\PostStatus;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Stats
        $totalPosts = $user->posts()->count();
        $publishedPosts = $user->posts()->where('status', PostStatus::Published)->count();
        $draftPosts = $user->posts()->where('status', PostStatus::Draft)->count();
        
        // Recent posts
        $recentPosts = $user->posts()->with('category')->latest()->take(5)->get();
        
        return view('dashboard', compact('totalPosts', 'publishedPosts', 'draftPosts', 'recentPosts'));
    }
}
