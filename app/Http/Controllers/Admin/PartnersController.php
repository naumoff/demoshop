<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\CalculateCardsLimit;
use App\Http\Requests\StorePartnerPost;
use App\Http\Requests\StorePaymentCardPost;
use App\Http\Requests\UpdatePaymentCardPatch;
use App\Http\Requests\UpdatePaymentPartnerPatch;
use App\PaymentCard;
use App\PaymentPartner;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PartnersController extends Controller
{
    use CalculateCardsLimit;
    
    #region MAIN METHODS
    public function index()
    {
        $partners = PaymentPartner::orderBy('sequence')->paginate(10);
        return view('admin.partners.partners',['partners'=>$partners]);
    }

    public function create()
    {
        $lastPartnerId = PaymentPartner::getLastPartnerId();
        
        return view('admin.partners.create-partner',
            [
                'nextPartnerId' => ($lastPartnerId + 1)
            ]
        );
    }

    public function store(StorePartnerPost $request)
    {
        if($request->input('active') == null){
            $request->merge(['active'=>0]);
        }
        
        $partner = new PaymentPartner();
        $partner->sequence = $request->input('sequence');
        $partner->first_name = $request->input('first-name');
        $partner->last_name = $request->input('last-name');
        $partner->email = $request->input('email');
        $partner->total_limit_eur = $request->input('total-limit-eur');
        $partner->total_cards_limit_eur = 0;
        $partner->total_invoiced_eur = 0;
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
    
    public function updatePaymentCard(UpdatePaymentCardPatch $request, PaymentCard $paymentCard)
    {
        if($request->input('active') == null){
            $request->merge(['active'=>0]);
        }
        
        $paymentCard->bank = $request->input('bank');
        $paymentCard->card_number = $request->input('card-number');
        $paymentCard->card_limit_eur = $request->input('card-limit-eur');
        $paymentCard->active = $request->input('active');
        $paymentCard->save();
        $this->saveTotalCardsLimitAmount($paymentCard->paymentPartner->id);
        return redirect()->back();
    }

    public function edit($id)
    {
        $partner = PaymentPartner::find($id);
        return view('admin.partners.edit-partner',[
            'partner'=>$partner
        ]);
    }

    public function update(UpdatePaymentPartnerPatch $request, PaymentPartner $partner)
    {
        if($request->input('active') == null){
            $request->merge(['active'=>0]);
        }
        $partner->sequence = $request->input('sequence');
        $partner->first_name = $request->input('first-name');
        $partner->last_name = $request->input('last-name');
        $partner->email = $request->input('email');
        $partner->total_limit_eur = $request->input('total-limit-eur');
        $partner->active = $request->input('active');
        $partner->save();
        return back();
    }

    public function destroy(PaymentPartner $partner)
    {
       $partner->delete();
       return 'SUCCESS';
    }
    #endregion
    
    #region AJAX METHODS
    
    //change current payment partner
    public function changePartnerCurrent(Request $request)
    {
        $partnerId = $request->input('partner-id');
        $oldValue = $request->input('old-value');
        
        echo $partnerId.'-'.$oldValue;
    }
    
    //block - unblock payment partner
    public function changePartnerActivity(Request $request)
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
    
    public function changeCardActivity(Request $request)
    {
        $cardId = $request->input('card-id');
        $oldValue = $request->input('old-value');
    
        if($oldValue == 0 || $oldValue == null){
            $newValue = 1;
        }else{
            $newValue = 0;
        }
    
        $card = PaymentCard::find($cardId);
        $card->active = $newValue;
        $card->save();
    
        $this->saveTotalCardsLimitAmount($card->paymentPartner->id);
        
        return 'SUCCESS';
    }
    
    public function deletePaymentCardFromPartner(Request $request)
    {
        $cardId = PaymentCard::find($request->input('card-id'));
        $cardId->delete();
        $this->saveTotalCardsLimitAmount($request->input('partner-id'));
        return 'SUCCESS';
    }
    #endregion
    
    #region SERVICE METHODS

    #endregion
}
