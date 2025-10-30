<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;
use App\Enums\PostStatus;

class Post extends Model
{

    use HasFactory;
    protected $fillable = [
        'title',
        'content',
        'user_id',
        'category_id',
        'status',
        'image',
        'views',
    ];

    protected $appends = ['reaction_counts', 'total_reactions'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class)->withTimestamps();
    }

    public function reactions(){
        return $this->hasMany(Reaction::class);
    }

    // Get reaction counts grouped by type
    public function getReactionCountsAttribute()
    {
        // Cache the result to avoid multiple queries
        if (!isset($this->attributes['_reaction_counts_cache'])) {
            $counts = $this->reactions()
                ->selectRaw('type, COUNT(*) as count')
                ->groupBy('type')
                ->pluck('count', 'type');
            
            $this->attributes['_reaction_counts_cache'] = $counts;
        }
        
        return $this->attributes['_reaction_counts_cache'];
    }

    // Get total reactions count
    public function getTotalReactionsAttribute()
    {
        return $this->reactions()->count();
    }

    // Check if user has reacted to this post
    public function userReaction($userId = null)
    {
        $userId = $userId ?? auth()->id();
        return $this->reactions()->where('user_id', $userId)->first();
    }

    // Check if current user has reacted with specific type
    public function hasReaction($type, $userId = null)
    {
        $userId = $userId ?? auth()->id();
        return $this->reactions()
            ->where('user_id', $userId)
            ->where('type', $type)
            ->exists();
    }

    public function getExcerptAttribute()
    {
        return Str::limit(strip_tags($this->content), 150);
    }

    public function getStatusLabelAttribute()
    {
        return $this->status->label();
    }

    public function scopeLatestPosts($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    public function scopeMostViewed($query, $limit = 5)
    {
        return $query->orderBy('views', 'desc')->limit($limit);
    }

    // Increment views
    public function incrementViews()
    {
        $this->increment('views');
    }

    // Format views count (1.2K, 1.5M, etc.)
    public function getFormattedViewsAttribute()
    {
        if ($this->views >= 1000000) {
            return round($this->views / 1000000, 1) . 'M';
        } elseif ($this->views >= 1000) {
            return round($this->views / 1000, 1) . 'K';
        }
        return $this->views;
    }

    public function casts(): array
    {
        return [
            'status' => PostStatus::class,
        ];
    }
}


