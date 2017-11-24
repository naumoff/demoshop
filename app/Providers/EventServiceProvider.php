<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\CustomerRegistered' => [
            'App\Listeners\SaveNewPasswordForCustomer',
            'App\Listeners\SendNewPasswordToCustomer',
        ],
        
        'App\Events\CustomerRejected' => [
            'App\Listeners\SaveRejectStatusForCustomer',
            'App\Listeners\SendRejectReasonToCustomer',
        ],
        
        'App\Events\CustomerSuspended' => [
            'App\Listeners\SaveSuspendStatusForCustomer',
            'App\Listeners\SendSuspendReasonToCustomer',
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
