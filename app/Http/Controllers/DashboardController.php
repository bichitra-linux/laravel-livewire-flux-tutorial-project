<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\NewsletterSubscriber;
use App\Models\Reaction;
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

        //Newsletter Stats
        $newsletterSubscribers = NewsletterSubscriber::active()->count();
        $newSubscribersToday = NewsletterSubscriber::whereDate('created_at', today())->count();

        //Engagement Stats
        $totalViews = $user->posts()->sum('views');
        $totalReactions = Reaction::whereIn('post_id', $user->posts()->pluck('id'))->count();

        //Categories
        $totalCategories = Category::count();
        $topCategories = Category::withCount('posts')->orderBy('posts_count', 'desc')->take(5)->get();

        // Recent posts
        $recentPosts = $user->posts()->with('category')->latest()->take(5)->get();

        return view('dashboard', compact(
            'totalPosts',
            'publishedPosts',
            'draftPosts',
            'newsletterSubscribers',
            'newSubscribersToday',
            'totalViews',
            'totalReactions',
            'totalCategories',
            'topCategories',
            'recentPosts'
        ));
    }
}
