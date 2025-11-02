<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewsletterWelcome extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {

        $unsubscribeUrl = route('newsletter.unsubscribe', $notifiable->token);
        return (new MailMessage)
            ->subject('🎉 Welcome! to ' . config('app.name') . ' Newsletter!')
            ->greeting('Hello!' . ($notifiable->name ? '' . $notifiable->name : '') . '!')
            ->line('Thank you for subscribing to our newsletter! ')
            ->line('You\'ll receive the latest updates and exclusive content directly to your inbox.')
            ->line('We publish new content regularly, covering topics like:')
            ->line('- Technology Trends')
            ->line('- Product Updates')
            ->line('- Industry News')
            ->line('And more. Stay tuned for exciting updates and insights!')
            ->line('We\'re thrilled to have you on board and can\'t wait to share our latest news with you!')
            ->line('')
            ->line('If you ever wish to unsubscribe, you can do so at any time by clicking the link below.')
            ->line('[Unsubscribe from newsletter](' . $unsubscribeUrl . ')')
            ->salutation('Best regards, ' . config('app.name') . ' Team');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
