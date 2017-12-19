<?php

namespace App\Http\Controllers\Admin;

use App\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrdersController extends Controller
{
    #region MAIN METHODS
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

    public function loadProductsForOrder(Order $order)
    {
        return view('inclusions.admin.order.products',['order'=>$order]);
    }

    public function loadPackagesForOrder(Order $order)
    {
        return view('inclusions.admin.order.packages',['order'=>$order]);
    }

    public function loadPresentForOrder(Order $order)
    {
        return view('inclusions.admin.order.present',['order'=>$order]);
    }

    public function loadCostForOrder(Order $order)
    {
        dd('cost');
    }

    public function loadAddressForOrder(Order $order)
    {
        dd('address');
    }

    public function loadPartnerForOrder(Order $order)
    {
        dd('partner');
    }
    #endregion

    #region SERVICE METHODS
    #endregion
}
