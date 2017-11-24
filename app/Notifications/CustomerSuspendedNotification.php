<?php

namespace App\Notifications;

use App\Events\CustomerSuspended;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class CustomerSuspendedNotification extends Notification
{
    use Queueable;
    
    private $user;
    private $reason;
    
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(CustomerSuspended $event)
    {
        $this->user = $event->user;
        $this->reason = $event->reason;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject("отзыв регистрации на ресурсе {$_ENV['APP_NAME']}")
            ->markdown('mail.suspended.customer.reason',
                [
                    'userName' => $this->user->first_name,
                    'reason' => $this->reason
                ]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
