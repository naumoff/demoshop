<?php

namespace App\Listeners\Products;

use App\Events\ExchangeRateUpdated;
use App\Product;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UpdateAllProductsPrices
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
        $currentEurRubRate = $event->currencyRate->currentEurRubRate;
        $products = Product::all();
        foreach ($products AS $product){
            $product->updatePriceRubAuto($currentEurRubRate);
            $product->save();
        }
    }
}
