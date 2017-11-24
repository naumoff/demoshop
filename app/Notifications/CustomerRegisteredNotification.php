<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Events\CustomerRegistered;

class CustomerRegisteredNotification extends Notification
{
    use Queueable;
    
    private $user;
    private $password;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(CustomerRegistered $event)
    {
        $this->user = $event->user;
        $this->password = $event->generatedPassword;
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
            ->subject("получена регистрация на ресурсе {$_ENV['APP_NAME']}")

            ->markdown('mail.registered.customer.password',
                [
                    'url' => url('/login'),
                    'userName' => $this->user->first_name,
                    'login' => $this->user->email,
                    'password'=> $this->password
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
