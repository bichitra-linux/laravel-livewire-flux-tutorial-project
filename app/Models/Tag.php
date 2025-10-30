<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Tag extends Model
{
    //
    use hasFactory;

    protected $fillable = ['name', 'slug'];

    public function posts(){
        return $this->belongsToMany(Post::class);
    }

    protected static function boot(){
        parent::boot();

        static::creating(function ($tag) {
            if (empty($tag->slug)) {
                $tag->slug = Str::slug($tag->name);
            }
        });
    }

}
