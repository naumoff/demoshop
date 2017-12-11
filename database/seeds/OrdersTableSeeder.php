<?php

use Illuminate\Database\Seeder;

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
            
            //adding package to product
            $packageQtyLimit = rand(0,4);
            for($qty=0; $qty<$packageQtyLimit; $qty++){
                factory(\App\OrderPackage::class)->create([
                    'order_id'=>$orderId,
                ]);
            }
        }

    }
}
