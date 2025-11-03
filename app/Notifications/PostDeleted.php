<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class PostDeleted extends Notification
{
    use Queueable;

    public function __construct(public string $postTitle)
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
            'type' => 'post_deleted',
            'post_title' => $this->postTitle,
            'message' => 'Post "' . $this->postTitle . '" has been deleted',
            'icon' => '🗑️',
        ];
    }
}