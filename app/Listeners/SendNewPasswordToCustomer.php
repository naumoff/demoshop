<?php

namespace App\Listeners;

use App\Events\CustomerRegistered;
use App\Notifications\CustomerRegisteredNotification;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendNewPasswordToCustomer
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  CustomerRegistered  $event
     * @return void
     */
    public function handle(CustomerRegistered $event)
    {
        $event->user->notify(new CustomerRegisteredNotification($event));
    }
}
