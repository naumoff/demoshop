<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\StorePartnerPost;
use App\PaymentPartner;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PartnersController extends Controller
{
    #region MAIN METHODS
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $partners = PaymentPartner::paginate(10);
        return view('admin.partners.partners',['partners'=>$partners]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.partners.create-partner');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePartnerPost $request)
    {
        if($request->input('suspended') == null){
            $request->merge(['suspended'=>0]);
        }
        
        $partner = new PaymentPartner();
        $partner->first_name = $request->input('first-name');
        $partner->last_name = $request->input('last-name');
        $partner->email = $request->input('email');
        $partner->total_limit_eur = $request->input('total-limit-eur');
        $partner->total_cards_eur = 0;
        $partner->active = 0;
        $partner->suspended = $request->input('suspended');
        $partner->save();
        return redirect()->route('admin-partner-add-card',['part_id'=>$partner->id]);
    }
    
    public function createPaymentCard($partnerId)
    {
        $partner = PaymentPartner::find($partnerId);
        return view('admin.partners.create-partner-card',[
            'partner'=>$partner
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    #endregion
    
    #region AJAX METHODS
    public function changeActivity(Request $request)
    {
        $partnerId = $request->input('partner-id');
        $oldValue = $request->input('old-value');
        
        echo $partnerId.'-'.$oldValue;
    }
    
    public function changeSuspension(Request $request)
    {
        $partnerId = $request->input('partner-id');
        $oldValue = $request->input('old-value');
        
        if($oldValue == 0 | $oldValue == null){
            $newValue = 1;
        }else{
            $newValue = 0;
        }
        
        $partner = PaymentPartner::find($partnerId);
        $partner->suspended = $newValue;
        $partner->save();
        return 'SUCCESS';
    }
    #endregion
    
    #region SERVICE METHODS
    
    #endregion
}
