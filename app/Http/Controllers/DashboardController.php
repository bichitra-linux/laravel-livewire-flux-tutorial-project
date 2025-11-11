<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\NewsletterSubscriber;
use App\Models\Reaction;
use App\Models\Comment;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Enums\PostStatus;
use App\Enums\ReactionType;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Post Statistics
        $totalPosts = $user->posts()->count();
        $publishedPosts = $user->posts()->where('status', PostStatus::Published)->count();
        $draftPosts = $user->posts()->where('status', PostStatus::Draft)->count();

        // Newsletter Stats
        $newsletterSubscribers = NewsletterSubscriber::where('is_subscribed', true)->count();
        $newSubscribersToday = NewsletterSubscriber::where('is_subscribed', true)
            ->whereDate('created_at', today())
            ->count();

        // Engagement Stats
        $totalViews = $user->posts()->sum('views');
        $totalReactions = Reaction::whereIn('post_id', $user->posts()->pluck('id'))->count();
        
        // Comment Stats
        $totalComments = Comment::whereIn('post_id', $user->posts()->pluck('id'))
            ->where('is_approved', true)
            ->count();
        $pendingComments = Comment::whereIn('post_id', $user->posts()->pluck('id'))
            ->where('is_approved', false)
            ->count();

        // Categories
        $totalCategories = Category::count();
        
        // FIX: Filter categories with posts - Compatible with SQLite
        $topCategories = Category::withCount('posts')
            ->orderBy('posts_count', 'desc')
            ->take(5)
            ->get()
            ->filter(function($category) {
                return $category->posts_count > 0;
            });

        // Recent Posts
        $recentPosts = $user->posts()
            ->with('category')
            ->latest()
            ->take(5)
            ->get();

        // Reaction Breakdown
        $reactionBreakdown = [];
        foreach (ReactionType::cases() as $type) {
            $reactionBreakdown[$type->value] = Reaction::whereIn('post_id', $user->posts()->pluck('id'))
                ->where('type', $type)
                ->count();
        }

        // Top Post (most engaged in last 7 days)
        $topPost = $user->posts()
            ->where('status', PostStatus::Published)
            ->where('created_at', '>=', now()->subWeek())
            ->withCount(['reactions', 'comments'])
            ->get()
            ->sortByDesc(function($post) {
                return $post->reactions_count + $post->comments_count;
            })
            ->first();

        // Engagement Rate
        $engagementRate = $totalViews > 0 
            ? (($totalReactions + $totalComments) / $totalViews) * 100 
            : 0;

        // Recent Activities
        $recentActivities = $this->getRecentActivities($user);

        return view('dashboard', compact(
            'totalPosts',
            'publishedPosts',
            'draftPosts',
            'newsletterSubscribers',
            'newSubscribersToday',
            'totalViews',
            'totalReactions',
            'totalComments',
            'pendingComments',
            'totalCategories',
            'topCategories',
            'recentPosts',
            'reactionBreakdown',
            'topPost',
            'engagementRate',
            'recentActivities'
        ));
    }

    private function getRecentActivities($user)
    {
        $activities = [];

        // Recent posts (last 3)
        $recentPosts = $user->posts()->latest()->take(3)->get();
        foreach ($recentPosts as $post) {
            $activities[] = [
                'description' => "Published: " . \Illuminate\Support\Str::limit($post->title, 50),
                'time' => $post->created_at->diffForHumans(),
                'color' => 'bg-blue-100 dark:bg-blue-900/30',
                'icon' => '<svg class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>',
                'timestamp' => $post->created_at->timestamp
            ];
        }

        // Recent comments (last 5)
        $recentComments = Comment::whereIn('post_id', $user->posts()->pluck('id'))
            ->with('user', 'post')
            ->latest()
            ->take(5)
            ->get();
        
        foreach ($recentComments as $comment) {
            $activities[] = [
                'description' => ($comment->user->name ?? 'Guest') . " commented on: " . \Illuminate\Support\Str::limit($comment->post->title, 40),
                'time' => $comment->created_at->diffForHumans(),
                'color' => 'bg-green-100 dark:bg-green-900/30',
                'icon' => '<svg class="w-4 h-4 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>',
                'timestamp' => $comment->created_at->timestamp
            ];
        }

        // Recent reactions (last 5)
        $recentReactions = Reaction::whereIn('post_id', $user->posts()->pluck('id'))
            ->with('user', 'post')
            ->latest()
            ->take(5)
            ->get();

        foreach ($recentReactions as $reaction) {
            $activities[] = [
                'description' => ($reaction->user->name ?? 'Guest') . " reacted " . $reaction->type->emoji() . " to: " . \Illuminate\Support\Str::limit($reaction->post->title, 40),
                'time' => $reaction->created_at->diffForHumans(),
                'color' => 'bg-pink-100 dark:bg-pink-900/30',
                'icon' => '<svg class="w-4 h-4 text-pink-600 dark:text-pink-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>',
                'timestamp' => $reaction->created_at->timestamp
            ];
        }

        // Sort by timestamp (newest first) and limit to 10
        usort($activities, function($a, $b) {
            return $b['timestamp'] - $a['timestamp'];
        });

        return array_slice($activities, 0, 10);
    }
}