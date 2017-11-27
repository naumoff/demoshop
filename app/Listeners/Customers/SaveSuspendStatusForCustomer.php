<?php

namespace App\Listeners\Customers;

use App\Events\CustomerSuspended;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SaveSuspendStatusForCustomer
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
        $event->user->status = config('lists.user_status.suspended.en');
        $event->user->save();
    }
}
