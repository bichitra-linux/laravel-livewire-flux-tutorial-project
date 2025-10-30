<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Reaction extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        'user_id',
        'post_id',
        'type',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function post(){
        return $this->belongsTo(Post::class);
    }

    public function getEmojiAttribute(){
        return match($this->type){
            'like' => '👍',
            'love' => '❤️',
            'haha' => '😂',
            'wow' => '😮',
            'sad' => '😢',
            'angry' => '😠',
            default => '👍',
        };
    }

    public function getColorAttribute(){
        return match($this->type) {
            'like' => 'text-blue-500',
            'love' => 'text-red-500',
            'care' => 'text-yellow-500',
            'haha' => 'text-yellow-400',
            'wow' => 'text-purple-500',
            'sad' => 'text-gray-500',
            'angry' => 'text-orange-500',
            default => 'text-blue-500',
        };
    }
}
