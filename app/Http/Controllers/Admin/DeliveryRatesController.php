<?php

namespace App\Http\Controllers\Admin;

use App\DeliveryRate;
use App\Http\Requests\StoreDeliveryPost;
use App\Http\Requests\UpdateDeliveryPatch;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DeliveryRatesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $deliveries = DeliveryRate::orderBy('min_weight','ASC')->paginate(10);
        return view('admin.sales.deliveries',['deliveries'=>$deliveries]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDeliveryPost $request)
    {
        $deliveryPrice = new DeliveryRate();
        $deliveryPrice->min_weight = $request->input('min-weight');
        $deliveryPrice->max_weight = $request->input('max-weight');
        $deliveryPrice->delivery_cost = $request->input('delivery-cost');
        $deliveryPrice->save();
        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateDeliveryPatch $request, DeliveryRate $delivery)
    {
        $delivery->min_weight = $request->input('min-weight');
        $delivery->max_weight = $request->input('max-weight');
        $delivery->delivery_cost = $request->input('delivery-cost');
        $delivery->save();
        return redirect()->back();
    }

    #region AJAX METHODS
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(DeliveryRate $delivery)
    {
        $delivery->delete();
        return 'SUCCESS';
    }
    #endregion
}
