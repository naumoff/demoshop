<?php

namespace App\Listeners;

use App\Events\CustomerRejected;
use App\Notifications\CustomerRegisteredNotification;
use App\Notifications\CustomerRejectedNotification;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendRejectReasonToCustomer
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
     * @param  CustomerRejected  $event
     * @return void
     */
    public function handle(CustomerRejected $event)
    {
        $event->user->notify(new CustomerRejectedNotification($event));
    }
}
