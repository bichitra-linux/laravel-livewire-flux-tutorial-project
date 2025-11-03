<?php

namespace App\Notifications;

use App\Models\Post;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class PostUpdated extends Notification
{
    use Queueable;

    public function __construct(public Post $post)
    {
        //
        $this->delay(now()->addSeconds(10));
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'post_updated',
            'post_id' => $this->post->id,
            'post_title' => $this->post->title,
            'post_status' => $this->post->status->value,
            'message' => 'Post "' . $this->post->title . '" has been updated',
            'action_url' => route('posts.show', $this->post->id),
            'icon' => '🔄',
        ];
    }
}