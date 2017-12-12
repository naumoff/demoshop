<?php

namespace App\Listeners\Packages;

use App\Events\ExchangeRateUpdated;
use App\Jobs\Packages\UpdatePackageJob;
use App\Package;
use App\Product;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UpdateAllPackagesPrices
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
     * @param  ExchangeRateUpdated  $event
     * @return void
     */
    public function handle(ExchangeRateUpdated $event)
    {
        $packages = Package::all();
        
        foreach ($packages AS $package){
            UpdatePackageJob::dispatch($package);
        }
    }
}
