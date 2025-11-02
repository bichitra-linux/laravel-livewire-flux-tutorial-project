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
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {

        $unsubscribeUrl = route('newsletter.unsubscribe', $notifiable->token);
        $postUrl = route('public.posts.show', $this->post->id);

        $excerpt = $this->post->excerpt ?? strip_tags(substr($this->post->content, 0, 200)) . '...';
        return (new MailMessage)
            ->subject('📢 New Post: ' . $this->post->title)
            ->greeting('Hello' . ($notifiable->name ? ' ' . $notifiable->name : '') . '!')
            ->line('A new post has been published on our blog.')
            ->line('')
            ->line('**' . $this->post->title . '**')
            ->line('')
            ->line($excerpt)
            ->line('')
            ->action('Read Full Post ->', $postUrl)
            ->line('')
            ->line('---')
            ->line('📝 **Written by:** ' . $this->post->user->name)
            ->line('📅 **Published:** ' . $this->post->created_at->format('F d, Y'))
            ->line('📁 **Category:** ' . ($this->post->category?->name ?? 'Uncategorized'))
            ->line('')
            ->line('Thank you for being part of our community! We appreciate your support.')
            ->line('')
            ->line('[Unsubscribe from newsletter](' . $unsubscribeUrl . ')')
            ->salutation('Happy reading!  ' . "\n" . 'The ' . config('app.name') . ' Team');

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