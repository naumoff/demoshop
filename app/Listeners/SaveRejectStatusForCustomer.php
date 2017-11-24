<?php

namespace App\Listeners;

use App\Events\CustomerRejected;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SaveRejectStatusForCustomer
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
        $event->user->status = config('lists.user_status.rejected.en');
        $event->user->save();
    }
}
