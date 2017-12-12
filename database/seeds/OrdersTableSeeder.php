<?php

use Illuminate\Database\Seeder;
use App\Jobs\Orders\CalculateGoodsCostForOrderJob;
use App\Jobs\Orders\CompileInvoiceForOrder;

class OrdersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($ordersQty=0; $ordersQty<200; $ordersQty++){
            $orderId = factory(\App\Order::class)->create()->id;
    
            $productsQtyLimit = rand(1,4);
    
            //adding products to order
            for($qty = 0; $qty<$productsQtyLimit; $qty++){
                factory(\App\OrderProduct::class)->create([
                    'order_id'=>$orderId,
                ]);
            }
            
            //adding packages to order
            $packageQtyLimit = rand(0,4);
            for($qty=0; $qty<$packageQtyLimit; $qty++){
                factory(\App\OrderPackage::class)->create([
                    'order_id'=>$orderId,
                ]);
            }

            $updatedOrder1 = \App\Order::find($orderId);
            CalculateGoodsCostForOrderJob::dispatch($updatedOrder1);
            
            //adding random present to order
            $updatedOrder2 = \App\Order::find($orderId);
            $goodsCost = $updatedOrder2->order_goods_cost;
            $presents = \App\Present::getAvailablePresents($goodsCost);
            
            if(count($presents) > 0){
                $updatedOrder2->present_id = $presents[rand(0,count($presents)-1)]->id;
                $updatedOrder2->save();
            }
            
            CompileInvoiceForOrder::dispatch($updatedOrder2);
        }
    }
}
