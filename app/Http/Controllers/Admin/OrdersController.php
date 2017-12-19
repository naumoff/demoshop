<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\UpdateOrderReceptorPatch;
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
            'paymentPartner'=> $paymentPartner,
        ]);
    }

    public function loadProductsForOrder(Order $order)
    {
        return view('inclusions.admin.order.products',[
            'order'=>$order,
        ]);
    }

    public function loadPackagesForOrder(Order $order)
    {
        return view('inclusions.admin.order.packages',[
            'order'=>$order,
        ]);
    }

    public function loadPresentForOrder(Order $order)
    {
        return view('inclusions.admin.order.present',[
            'order'=>$order,
        ]);
    }

    public function loadPartnerForOrder(Order $order)
    {
        return view('inclusions.admin.order.partner',[
            'order'=>$order,
        ]);
    }

    public function loadAddressForOrder(Order $order)
    {
        return view('inclusions.admin.order.address',[
            'order'=>$order,
        ]);
    }

    public function updateOrderReceptor(UpdateOrderReceptorPatch $request)
    {
        $order = Order::find($request->input('order_id'));
        return redirect()->route('admin-order-edit',[
            'order'=>$order->id,
            'tab'=>'delivery' // will be added to GET params
        ]);
    }

    public function loadStatusForOrder(Order $order)
    {
        return view('inclusions.admin.order.status',[
            'order'=>$order
        ]);
    }
    #endregion

    #region SERVICE METHODS
    #endregion
}
