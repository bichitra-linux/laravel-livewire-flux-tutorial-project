<?php

namespace App\Observers;

use App\Models\Post;
use App\Enums\PostStatus;
use App\Notifications\PostCreated;
use App\Notifications\PostUpdated;
use App\Notifications\PostDeleted;
use App\Notifications\PostPublished;
use App\Models\NewsletterSubscriber;
use Illuminate\Support\Facades\Log;
use App\Services\CacheService;
use Illuminate\Support\Facades\Notification;

class PostObserver
{
    public function creating(Post $post): void
    {
        if (!$post->status) {
            $post->status = PostStatus::Draft;
        }
        Log::info('Post is being created: ' . $post->title);
    }

    public function created(Post $post): void
    {
        Log::info('Post created', [
            'post_id' => $post->id,
            'user_id' => $post->user_id,
            'status' => $post->status->value,
        ]);
        // Notify the author
        if ($post->user) {
            $post->user->notify(new PostCreated($post));
        }

        if ($post->status === PostStatus::Published) {
            Log::info('Post created with Published status, notifying subscribers...');
            $this->notifySubscribersAboutNewPost($post);
        }

        CacheService::clearPostCache();
    }

    public function updating(Post $post): void
    {
        Log::info('Post is being updated: ' . $post->title);
    }

    public function updated(Post $post): void
    {
        Log::info('Post updated successfully: ' . $post->title);

        // Notify the author
        if ($post->user) {
            $post->user->notify(new PostUpdated($post));
        }

        // If status changed to Published, notify subscribers
        if ($post->isDirty('status') && $post->status === PostStatus::Published) {
            Log::info('Post status changed to Published, notifying subscribers...');
            $this->notifySubscribersAboutNewPost($post);
        }

        CacheService::clearPostCache();
    }

    public function deleting(Post $post): void
    {
        Log::info('Post is being deleted: ' . $post->title);
    }

    public function deleted(Post $post): void
    {
        Log::info('Post deleted successfully: ' . $post->title);

        // Notify the author
        if ($post->user) {
            $post->user->notify(new PostDeleted($post->title));
        }

        CacheService::clearPostCache();
    }

    public function restored(Post $post): void
    {
        Log::info('Post restored successfully: ' . $post->title);
    }

    public function forceDeleted(Post $post): void
    {
        Log::info('Post force deleted: ' . $post->title);
    }

    /**
     * Notify newsletter subscribers about newly published post
     */
    protected function notifySubscribersAboutNewPost(Post $post): void
    {
        $subscribers = NewsletterSubscriber::where('is_subscribed', true)->get();
        Log::info('Found ' . $subscribers->count() . ' active subscribers');

        if ($subscribers->count() > 0) {
            try {
                Notification::send($subscribers, new PostPublished($post));
                Log::info('Newsletter subscribers notified about post: ' . $post->title . ' (Total: ' . $subscribers->count() . ')');
            } catch (\Exception $e) {
                Log::error('Error notifying subscribers about post: ' . $post->title . ' - ' . $e->getMessage());
            }

        } else {
            Log::info('No active subscribers to notify.');
        }
    }
}