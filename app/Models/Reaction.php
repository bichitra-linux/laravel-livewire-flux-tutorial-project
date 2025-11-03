<?php

namespace App\Models;

use App\Enums\ReactionType;
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

    /**
     * Get the reaction type as an enum.
     */

    protected function casts(): array{
        return [
            'type' => ReactionType::class,
        ];
    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function getEmojiAttribute(): string
    {
        return $this->type->emoji();
    }

    public function getColorAttribute(): string
    {
        return $this->type->color();
    }


    public function scopeOfType($query, ReactionType $type)
    {

        if($type instanceof ReactionType){
            return $query->where('type', $type->value);
        }
        return $query->where('type', $type);
    }
}
