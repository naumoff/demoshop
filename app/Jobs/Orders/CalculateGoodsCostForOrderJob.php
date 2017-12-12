<?php

namespace App\Jobs\Orders;

use App\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class CalculateGoodsCostForOrderJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $order;
    
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //getting products cost of order
        $productsCost = $this->getProductsCost();
    
        //getting packages cost of order
        $packagesCost = $this->getPackagesCost();
        
        $this->order->order_goods_cost = $productsCost + $packagesCost;
        $this->order->save();
    }
    
    private function getProductsCost()
    {
        $productCost = 0;
        foreach ($this->order->products AS $product){
            $productCost += $product->pivot->cost;
        }
        return $productCost;
    }
    
    private function getPackagesCost()
    {
        $packageCost = 0;
        foreach ($this->order->packages AS $package){
            $packageCost += $package->pivot->cost;
        }
        return $packageCost;
    }
    
}
