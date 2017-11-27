<?php

namespace App\Listeners\Customers;

use App\Events\CustomerSuspended;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Notifications\CustomerSuspendedNotification;

class SendSuspendReasonToCustomer
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
     * @param  CustomerSuspended  $event
     * @return void
     */
    public function handle(CustomerSuspended $event)
    {
        $event->user->notify(new CustomerSuspendedNotification($event));
    }
}
