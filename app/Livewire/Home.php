<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Post;
use App\Models\Tag;
use App\Models\Category;
use App\Enums\PostStatus;

class Home extends Component
{
    public $limit = 6; // Show only 6 posts on homepage
    public $search = '';
    public $category = null;

    public $currentSlide = 0;
    public $isPaused = false;

    // persist search in the URL so links/bookmarks keep filter
    protected $queryString = [
        'search' => ['except' => ''],
        'category' => ['except' => null],
    ];

    public function nextSlide($slideCount)
    {
        if (!$this->isPaused) {
            $this->currentSlide = ($this->currentSlide + 1) % $slideCount;
        }
    }

    public function goToSlide($index)
    {
        $this->currentSlide = $index;
        $this->isPaused = true; // Pause auto-slide when user manually navigates
    }

    public function resumeAutoSlide()
    {
        $this->isPaused = false;
    }

    public function render()
    {
        // Get Featured Posts (posts with "Featured" tag)
        $featuredTag = Tag::where('slug', 'featured')->first();
        
        $featuredPosts = collect();
        if ($featuredTag) {
            $featuredPosts = Post::with('user', 'category', 'tags')
                ->whereHas('tags', function($query) use ($featuredTag) {
                    $query->where('tags.id', $featuredTag->id);
                })
                ->where('status', PostStatus::Published)
                ->latest()
                ->take(5) // Limit to 5 featured posts for carousel
                ->get();
        }

        // Get regular posts (excluding featured ones)
        $query = Post::with('user', 'category', 'tags')
            ->latestPosts()
            ->where('status', PostStatus::Published);
        
        // Exclude featured posts from regular listing
        if ($featuredPosts->isNotEmpty()) {
            $query->whereNotIn('id', $featuredPosts->pluck('id'));
        }
            
        if ($this->search){
            $query->where(function($q) {
                $q->where('title', 'like', "%{$this->search}%")
                  ->orWhere('content', 'like', "%{$this->search}%");
            });
        }

        if ($this->category) {
            $query->where(function($q) {
                // If numeric, check both id and slug
                if (is_numeric($this->category)) {
                    $q->whereHas('category', function($subQuery) {
                        $subQuery->where('id', $this->category)
                                 ->orWhere('slug', $this->category);
                    });
                } else {
                    // If string, only check slug
                    $q->whereHas('category', function($subQuery) {
                        $subQuery->where('slug', $this->category);
                    });
                }
            });
        }

        // Get limited posts for homepage
        $posts = $query->take($this->limit)->get();
        
        // Check if there are more posts
        $totalPosts = Post::where('status', PostStatus::Published)->count();
        $hasMore = $totalPosts > ($this->limit + $featuredPosts->count());
        
        $categories = Category::orderBy('name')->get();
        
        // Load popular tags with post count
        $popularTags = Tag::withCount('posts')
            ->orderBy('posts_count', 'desc')
            ->take(8)
            ->get();
            
        return view('livewire.home', compact('posts', 'featuredPosts', 'categories', 'popularTags', 'hasMore', 'totalPosts'));
    }
}