<?php

namespace App\Jobs\Orders;

use App\DeliveryRate;
use App\Order;
use App\Services\PaymentPartnerSelectorService;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class CompileInvoiceForOrder implements ShouldQueue
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
        //calculating order delivery cost
        $orderWeight = $this->getOrderWeight(); //with present
        $this->order->order_weight = $orderWeight;
        
        $deliveryCost = DeliveryRate::calculateDeliveryCost($orderWeight);
        if($deliveryCost !== false){
            $this->order->order_delivery_cost = $deliveryCost;
        }else{
            $this->order->order_delivery_cost = 0;
        }
        
        //calculating invoice total amount
        $this->order->order_total_invoice_amount =
            $this->order->order_goods_cost + $this->order->order_delivery_cost;
        
        //payment partner selection
        $paymentPartnerSelector = new PaymentPartnerSelectorService($this->order);
        $paymentPartnerSelector->setPaymentCardForOrder();
        $this->order->save();
    }
    
    private function getOrderWeight()
    {
        $orderWeight = 0;
        foreach ($this->order->products AS $product){
            $orderWeight += $product->pivot->weight;
        }
        
        foreach ($this->order->packages AS $package){
            $orderWeight += $package->pivot->weight;
        }
        
        if($this->order->present !== null){
            $orderWeight += $this->order->present->weight_gr;
        }
        
        return $orderWeight;
    }
}
