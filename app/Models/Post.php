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
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
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

    public function casts(): array
    {
        return [
            'status' => PostStatus::class,
        ];
    }
}


