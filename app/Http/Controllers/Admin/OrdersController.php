<?php

namespace App\Http\Controllers\Admin;

use App\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrdersController extends Controller
{
    public function notPaidOrders()
    {
        $orders = Order::notPaid()->valid()->paginate();
        return view('admin.orders.orders-not-paid',['orders'=>$orders]);
    }
    
    public function paidOrders()
    {
    
    }
    
    public function dispatchedOrders()
    {
    
    }
    
    public function paymentOverdueOrders()
    {
    
    }

    public function orderEdit(Order $order)
    {
        $paymentPartner = $order->paymentCard->paymentPartner;
        return view('admin.orders.edit-order',[
            'order'=>$order,
            'paymentPartner'=> $paymentPartner
        ]);
    }
}
