<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Post;

class Analytics extends Model
{
    // 
    public $timestamps = false;

    protected $fillable = [
        'event_type',
        'user_id',
        'post_id',
        'ip_address',
        'user_agent',
        'referer',
        'metadata',
        'created_at',
    ];

    protected $casts = [
        'metadata' => 'array',
        'created_at' => 'datetime',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function post() {
        return $this->belongsTo(Post::class);
    }
}
