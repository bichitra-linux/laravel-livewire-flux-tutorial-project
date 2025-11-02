<?php

namespace App\Notifications;

use App\Models\Post;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PostPublished extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public Post $post)
    {
        //
    }

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('📢 New Post: ' . $this->post->title)
            ->greeting('Hello' . ($notifiable->name ? ' ' . $notifiable->name : '') . '!')
            ->line('A new post has been published on our blog.')
            ->line('**' . $this->post->title . '**')
            ->line($this->post->excerpt)
            ->action('Read Post', route('public.posts.show', $this->post->id))
            ->line('Thank you for subscribing to our newsletter!');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'post_published',
            'post_id' => $this->post->id,
            'post_title' => $this->post->title,
            'author' => $this->post->user->name,
            'message' => 'New post published: ' . $this->post->title,
            'action_url' => route('public.posts.show', $this->post->id),
            'icon' => '📢',
        ];
    }
}