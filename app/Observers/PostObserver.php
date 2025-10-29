<?php

namespace App\Observers;

use App\Models\Post;
use App\Enums\PostStatus;
use Illuminate\Support\Facades\Log;

class PostObserver
{
    /**
     * Handle the Post "created" event.
     */
    public function creating(Post $post): void
    {
        //
        if(!$post->status){
            $post->status = PostStatus::Draft;
        }
        Log::info('Post is being created: ' . $post->title);
    }

    public function created(Post $post): void
    {
        //
        Log::info('Post created successfully: ' . $post->title . ' by ' . ($post->user->name ?? 'Unknown'));
    }

    public function updating(Post $post): void
    {
        //
        Log::info('Post is being updated: ' . $post->title);
    }

    /**
     * Handle the Post "updated" event.
     */
    public function updated(Post $post): void
    {
        //
        Log::info('Post updated successfully: ' . $post->title);
    }

    public function deleting(Post $post): void
    {
        //
        Log::info('Post is being deleted: ' . $post->title);
    }

    /**
     * Handle the Post "deleted" event.
     */
    public function deleted(Post $post): void
    {
        //
        Log::info('Post deleted successfully: ' . $post->title);
    }

    

    /**
     * Handle the Post "restored" event.
     */
    public function restored(Post $post): void
    {
        //
        Log::info('Post restored successfully: ' . $post->title);
    }

    /**
     * Handle the Post "force deleted" event.
     */
    public function forceDeleted(Post $post): void
    {
        //
        Log::info('Post force deleted: ' . $post->title);
    }
}
