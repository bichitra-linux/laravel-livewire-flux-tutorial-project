<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Cache;
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

    protected $appends = ['reaction_counts', 'total_reactions', 'comments_count'];

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

    public function reactions()
    {
        return $this->hasMany(Reaction::class);
    }

    // UPDATED: Better caching
    public function getReactionCountsAttribute()
    {
       return Cache::remember("post.{$this->id}.reaction_counts", now()->addMinutes(5), function () {
        if ($this->relationLoaded('reactions')){
            return $this->reactions->groupBy('type')->map->count();
        }
        
        return $this->reactions()->selectRaw('type, COUNT(*) as count')
           ->groupBy('type')
           ->pluck('count', 'type');
       });
    }

    // UPDATED: Better performance
    public function getTotalReactionsAttribute()
    {
        return Cache::remember(
            "post.{$this->id}.total_reactions",
            now()->addMinutes(5),
            function() {
                if ($this->relationLoaded('reactions')) {
                    return $this->reactions->count();
                }
                return $this->reactions()->count();
            }
        );
    }

    // Check if user has reacted to this post
    public function userReaction($userId = null)
    {
        $userId = $userId ?? auth()->id();
        
        // If reactions are loaded, find in collection
        if ($this->relationLoaded('reactions')) {
            return $this->reactions->firstWhere('user_id', $userId);
        }
        
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

    public function incrementViews()
    {
        $this->increment('views');
    }

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

    protected static function booted(){
        static::updated(function ($post){

            $post->clearReactionCache();
        });

        static::deleted(function ($post) {

            $post->clearReactionCache();
        });
    }


    public function clearReactionCache(){
        Cache::forget("post.{$this->id}.reaction_counts");
        Cache::forget("post.{$this->id}.total_reactions");
    }

    public function getMostPopularReactionAttribute(): ?string{

        $mostPopular = $this->reactions()->selectRaw('type, COUNT(*) as count')
            ->groupBy('type')
            ->orderByDesc('count')
            ->first();

        return $mostPopular ? $mostPopular->type->value : null;
    }


    public function getReactionPercentageAttribute(): array{
        $total = $this->total_reactions;

        if($total === 0) return [];

        return $this->reaction_counts->map(fn($count) => round(($count / $total) * 100, 2))->toArray();
    }


    public function comments(){
        return $this->hasMany(Comment::class);
    }

    public function approvedComments(){
        return $this->hasMany(Comment::class)->approved();
    }

    public function getCommentsCountAttribute(){
        return $this->comments()->approved()->count();
    }

}