<?php

namespace App\Listeners;

use App\Events\CustomerRegistered;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SaveNewPasswordForCustomer
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
        $event->user->password = bcrypt($event->generatedPassword);
        $event->user->status = config('lists.user_status.approved.en');
        $event->user->save();
    }
}
