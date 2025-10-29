<?php

namespace App\Enums;

enum PostStatus: string
{
    case Draft = 'draft';
    case Published = 'published';
    case Archived = 'archived';

    public function label(): string
    {
        return match($this) {
            PostStatus::Draft => 'Draft',
            PostStatus::Published => 'Published',
            PostStatus::Archived => 'Archived',
        };
    }

    public function color(): string
    {
        return match($this) {
            PostStatus::Draft => 'gray',
            PostStatus::Published => 'green',
            PostStatus::Archived => 'red',
        };
    }
}
