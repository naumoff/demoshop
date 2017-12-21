<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\UpdateOrderReceptorPatch;
use App\Http\Requests\UpdateOrderStatusPatch;
use App\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrdersController extends Controller
{
    #region MAIN METHODS
    public function notPaidOrders()
    {
        $orders = Order::notPaid()->valid()->with('paymentCard.paymentPartner')->paginate();
        return view('admin.orders.orders-not-paid',['orders'=>$orders]);
    }
    
    public function paidOrders()
    {
        $orders = Order::paid()->with('paymentCard.paymentPartner')->paginate();
        return view('admin.orders.orders-paid',['orders'=>$orders]);
    }
    
    public function dispatchedOrders()
    {
        $orders = Order::dispatched()->with('paymentCard.paymentPartner')->paginate();
        return view('admin.orders.orders-dispatched',['orders'=>$orders]);
    }
    
    public function paymentOverdueOrders()
    {
        $orders = Order::overdue()->notPaid()->with('paymentCard.paymentPartner')->paginate();
        return view('admin.orders.orders-overdue',['orders'=>$orders]);

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

    public function loadReceptorForOrder(Order $order)
    {
        return view('inclusions.admin.order.address',[
            'order'=>$order,
        ]);
    }

    public function updateOrderReceptor(UpdateOrderReceptorPatch $request)
    {
        $order = Order::find($request->input('order_id'));

        $order->user_first_name = $request->input('user_first_name');
        $order->user_last_name = $request->input('user_last_name');
        $order->user_phone = $request->input('user_phone');
        $order->user_country = $request->input('user_country');
        $order->user_post_index = $request->input('user_post_index');
        $order->user_city = $request->input('user_city');
        $order->user_street = $request->input('user_street');
        $order->user_building_number = $request->input('user_building_number');
        $order->user_apartment_number = $request->input('user_apartment_number');
        $order->save();

        return redirect()->route('admin-order-edit',[
            'order'=>$order->id,
            'tab'=>'delivery' // will be added to GET params
        ]);
    }

    public function loadStatusForOrder(Order $order)
    {
        $orderStatus = config('lists.order_status');
        foreach ($orderStatus AS $statusItem){
            $orderStatusList[$statusItem['en']] = $statusItem['ru'];
        }

        $invoiceStatus = config('lists.invoice_status');
        foreach ($invoiceStatus AS $statusItem){
            $invoiceStatusList[$statusItem['en']] = $statusItem['ru'];
        }
        return view('inclusions.admin.order.status',[
            'order'=>$order,
            'orderStatusList'=>$orderStatusList,
            'invoiceStatusList'=>$invoiceStatusList
        ]);
    }

    public function updateOrderStatus(UpdateOrderStatusPatch $request)
    {
        $order = Order::find($request->input('order_id'));

        $order->order_status = $request->input('order_status');
        $order->delivery_track_number = $request->input('delivery_track_number');
        $order->invoice_status = $request->input('invoice_status');
        $order->save();

        return redirect()->route('admin-order-edit',[
            'order'=>$order->id,
            'tab'=>'status' // will be added to GET params
        ]);
    }
    #endregion

    #region SERVICE METHODS
    #endregion

    #region AJAX METHODS
    public function deleteOrder(Order $order)
    {
        $order->delete();
        return 'SUCCESS';
    }
    #endregion
}
