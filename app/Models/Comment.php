<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Comment extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        'post_id',
        'user_id',
        'content',
        'parent_id',
        'is_approved',
    ];

    protected $casts = [
        'is_approved' => 'boolean',
    ];

    protected $with = ['user'];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function parent()
    {
        return $this->belongsTo(Comment::class, 'parent_id');
    }

    public function replies()
    {
        return $this->hasMany(Comment::class, 'parent_id')->with('user')->orderBy('created_at', 'asc');
    }

    public function scopeApproved($query) {
        return $query->where('is_approved', true);
    }

    public function scopeParentOnly($query) {
        return $query->whereNull('parent_id');
    }

    public function isReply() {
        return !is_null($this->parent_id);
    }

    public function canEdit($user = null) {
        $user = $user ?? auth()->user();
        return $user && ($user->id === $this->user_id || $user->hasRole(['admin', 'editor']));
    }

    public function canDelete($user = null) {
        $user = $user ?? auth()->user();
        return $user && ($user->id === $this->user_id || $user->hasRole(['admin', 'editor']));
    }
}
