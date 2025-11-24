<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\URL;

class WelcomeEmail extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct()
    {
        //

        $this->delay(now()->addSeconds(10));
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

        $verificationUrl = $this->verificationUrl($notifiable);
        return (new MailMessage)
            ->subject('Welcome to ' . config('app.name') . '! 🎉')
            ->greeting('Hello ' . $notifiable->name . '!')
            ->line('Welcome to ' . config('app.name') . '! We\'re thrilled to have you on board.')
            ->line('Your account has been successfully created. Before you can start exploring, please verify your email address.')
            ->action('Verify Email Address', $verificationUrl)
            ->line('Once verified, you\'ll be able to:')
            ->line('  Read all our latest posts')
            ->line('  React to articles you love')
            ->line('  Subscribe to our newsletter')
            ->line('  Engage with our community')
            ->line('')
            ->line('If you did not create this account, no further action is required.')
            ->salutation('Best regards,' . "\n" . 'The ' . config('app.name') . ' Team');
    }

    protected function verificationUrl($notifiable): string{
        return URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(60),
            [
                'id' => $notifiable->getKey(),
                'hash' => sha1($notifiable->getEmailForVerification()),
            ]
        );
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
