<?php

namespace App\Notifications;

use App\Events\CustomerRejected;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class CustomerRejectedNotification extends Notification
{
    use Queueable;
    
    private $user;
    private $rejectionReason;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(CustomerRejected $event)
    {
        $this->user = $event->user;
        $this->rejectionReason = $event->reason;
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
            ->subject("отказ в регистрации не ресурсе {$_ENV['APP_NAME']}")
            ->markdown('mail.rejected.customer.reason',
                [
                    'userName' => $this->user->first_name,
                    'reason' => $this->rejectionReason,
                ]
            );
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
