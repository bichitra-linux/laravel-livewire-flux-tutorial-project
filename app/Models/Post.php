<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Post extends Model
{

    use HasFactory;
    protected $fillable =[
        'title',
        'content',
        'user_id',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function getExcerptAttribute(){
        return Str::limit(strip_tags($this->content), 150);
    }

    public function scopeLatestPosts($query){
        return $query->orderBy('created_at', 'desc');
    }
}


