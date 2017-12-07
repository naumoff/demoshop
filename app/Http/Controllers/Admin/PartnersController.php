<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\CalculateCardsLimit;
use App\Http\Requests\StorePartnerPost;
use App\Http\Requests\StorePaymentCardPost;
use App\Http\Requests\UpdatePaymentPartnerPatch;
use App\PaymentCard;
use App\PaymentPartner;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PartnersController extends Controller
{
    use CalculateCardsLimit;
    
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
        if($request->input('active') == null){
            $request->merge(['active'=>0]);
        }
        
        $partner = new PaymentPartner();
        $partner->first_name = $request->input('first-name');
        $partner->last_name = $request->input('last-name');
        $partner->email = $request->input('email');
        $partner->total_limit_eur = $request->input('total-limit-eur');
        $partner->total_cards_eur = 0;
        $partner->current = 0;
        $partner->active = $request->input('active');
        $partner->save();
        return redirect()->route('admin-partner-add-card',['part_id'=>$partner->id]);
    }
    
    public function createPaymentCard($partnerId)
    {
        $partner = PaymentPartner::find($partnerId);
        $cards = PaymentCard::getCards()->byHolderId($partnerId)->paginate(10);
        return view('admin.partners.create-partner-card',[
            'partner'=>$partner,
            'cards'=>$cards
        ]);
    }
    
    public function storePaymentCard(StorePaymentCardPost $request, $partnerId)
    {
        if($request->input('active') == null){
            $request->merge(['active'=>0]);
        }
        
        $paymentCard = new PaymentCard();
        $paymentCard->holder_id = $request->input('holder-id');
        $paymentCard->bank = $request->input('bank');
        $paymentCard->card_number = $request->input('card-number');
        $paymentCard->card_limit_eur = $request->input('card-limit-eur');
        $paymentCard->current = 0;
        $paymentCard->active = $request->input('active');
        $paymentCard->save();
        
        $this->saveTotalCardsLimitAmount($partnerId);
        
        return redirect()->back();
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
        $partner = PaymentPartner::find($id);
        return view('admin.partners.edit-partner',[
            'partner'=>$partner
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePaymentPartnerPatch $request, PaymentPartner $partner)
    {
        if($request->input('active') == null){
            $request->merge(['active'=>0]);
        }
        $partner->first_name = $request->input('first-name');
        $partner->last_name = $request->input('last-name');
        $partner->email = $request->input('email');
        $partner->total_limit_eur = $request->input('total-limit-eur');
        $partner->active = $request->input('active');
        $partner->save();
        return back();
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
    //change current payment partner
    public function changeCurrent(Request $request)
    {
        $partnerId = $request->input('partner-id');
        $oldValue = $request->input('old-value');
        
        echo $partnerId.'-'.$oldValue;
    }
    
    //block - unblock payment partner
    public function changeActivity(Request $request)
    {
        $partnerId = $request->input('partner-id');
        $oldValue = $request->input('old-value');
        
        if($oldValue == 0 | $oldValue == null){
            $newValue = 1;
        }else{
            $newValue = 0;
        }
        
        $partner = PaymentPartner::find($partnerId);
        $partner->active = $newValue;
        $partner->save();
        return 'SUCCESS';
    }
    #endregion
    
    #region SERVICE METHODS

    #endregion
}
