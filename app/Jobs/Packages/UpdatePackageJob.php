<?php

namespace App\Jobs\Packages;

use App\CurrencyRate;
use App\Package;
use App\PackageProduct;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class UpdatePackageJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $package;
    
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Package $package)
    {
        $this->package = $package;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $products = $this->package->products()->get();
        
        // update weight & price
        $weight = 0;
        $eurPrice = 0;
        foreach ($products AS $product){
            $weight += $product->weight_gr;
            $eurPrice += $product->price_eur;
        }
        $this->package->weight_gr = $weight;
        $this->package->price_eur = $eurPrice;
        $this->package->price_rub_auto = $eurPrice * CurrencyRate::getEurRubRate();
        $this->package->save();
    }
}
