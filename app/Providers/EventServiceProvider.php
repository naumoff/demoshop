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
            'App\Listeners\Customers\SaveNewPasswordForCustomer',
            'App\Listeners\Customers\SendNewPasswordToCustomer',
        ],
        
        'App\Events\CustomerRejected' => [
            'App\Listeners\Customers\SaveRejectStatusForCustomer',
            'App\Listeners\Customers\SendRejectReasonToCustomer',
        ],
        
        'App\Events\CustomerSuspended' => [
            'App\Listeners\Customers\SaveSuspendStatusForCustomer',
            'App\Listeners\Customers\SendSuspendReasonToCustomer',
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
