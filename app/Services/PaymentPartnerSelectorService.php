<?php
/**
 * Created by PhpStorm.
 * User: Sergey
 * Date: 13.12.2017
 * Time: 11:27
 */

namespace App\Services;

use App\CurrencyRate;
use App\Order;
use App\PaymentCard;
use App\PaymentPartner;

class PaymentPartnerSelectorService
{
    private $order;
    private $partner;
    private $card;
    private $orderAmountEur;
    
    #region MAIN METHODS
    public function __construct(Order $order)
    {
        $this->order = $order;
        $eurRubExchRate = CurrencyRate::getEurRubRate();
        $this->orderAmountEur = $this->order->order_total_invoice_amount / $eurRubExchRate;
    }
    
    /**
     * method set payment_card_id for order
     */
    public function setPaymentCardForOrder()
    {
        //current partner selection
        $this->setCurrentPartner();
        do{
            if($this->checkPartnerLimitWithOrderAmount() === false){
                //limit reached, partner rotated
                $this->rotatePaymentPartner();
            }
        }while($this->checkPartnerLimitWithOrderAmount() === false);
    
        
        //current card selection
        $this->setCurrentCard();
        do{
            if($this->checkCardBalanceWithOrderAmount() === false){
                //limit reached, card rotated
                $this->rotatePaymentCard();
            }
        }while($this->checkCardBalanceWithOrderAmount() === false);
    
        //store data to current Partner and current Card and current Order
        $this->saveAllData();
       
    }
    #endrgion
    
    #region SERVICE METHODS
    private function setCurrentPartner()
    {
        $currentPartner = PaymentPartner::active()->current()->first();

        if ($currentPartner === null) {
            $currentPartner = PaymentPartner::active()
                ->orderBySequence()
                ->whereHas('paymentCards',function($query){
                    $query->where('active','=',1);
                })
                ->first();
            PaymentPartner::where('current','=',1)->update(['current'=>0]);
            $currentPartner->current = 1;
            $currentPartner->save();
        }
        $this->partner = $currentPartner;
        return $currentPartner;
    }
    private function checkPartnerLimitWithOrderAmount()
    {
        $partnerLimitEur = $this->partner->total_limit_eur;
        $partnerBalanceEur = $this->partner->total_invoiced_eur;
        
        if(($this->orderAmountEur+$partnerBalanceEur)<$partnerLimitEur){
            return true;
        }else{
            return false;
        }
    }
    private function rotatePaymentPartner()
    {
        $this->cleanPostCurrentPartnerData();
    
        $this->partner = PaymentPartner::active()
            ->orderBySequence()
            ->next($this->partner->sequence, $this->partner->id)
            ->withinEurLimit($this->orderAmountEur)
            ->with('paymentCards')
            ->whereHas('paymentCards',function($query){
                $query->where('active','=',1);
            })
            ->first();
    
        if($this->partner !== null){
            $this->partner->current = 1;
            $this->partner->save();
        }else{
            $this->setCurrentPartner();
        }
    }
    private function cleanPostCurrentPartnerData()
    {
        //cleaning data for post current partner
        $this->partner->current = 0;
        $this->partner->total_invoiced_eur = 0;
        $this->partner->save();
        // cleaning post partner cards
        foreach ($this->partner->paymentCards AS $paymentCard) {
            $paymentCard->card_invoiced_eur = 0;
            $paymentCard->current = 0;
            $paymentCard->save();
        }
    }
    private function setCurrentCard()
    {
        $currentCard = $this->partner
            ->paymentCards()
            ->active()
            ->current()
            ->first();
        
        if ($currentCard == null) {
            $currentCard = $this->partner->paymentCards()->active()->orderById()->first();
            PaymentCard::where('current','=',1)->update(['current'=>0]);
            $currentCard->current = 1;
            $currentCard->save();
            $this->card = $currentCard;
        }
        $this->card = $currentCard;
        
        return $currentCard;
    }
    private function checkCardBalanceWithOrderAmount()
    {
        $cardBalance = $this->card->card_invoiced_eur;
        $cardLimit = $this->card->card_limit_eur;
        if($cardBalance > $cardLimit){
            return false;
        }else{
            return true;
        }
    }
    private function rotatePaymentCard()
    {
        $nextCurrentCard = PaymentCard::byHolderId($this->partner->id)
            ->orderById()
            ->active()
            ->next($this->card->id)
            ->first();
        if($nextCurrentCard !== null){
            //deactivating current status of post current card
            $this->card->current = 0;
            $this->card->save();
            
            //setting new current card
            $this->card = $nextCurrentCard;
            $this->card->current = 1;
            $this->card->save();
        }else{
            //new turn initiated with cards
            $this->cleanCardsData();
            $this->setCurrentCard();
        }
    }
    private function cleanCardsData()
    {
        PaymentCard::where('holder_id','=',$this->partner->id)
            ->update([
                'current'=>0,
                'card_invoiced_eur'=>0
            ]);
    }
    private function saveAllData()
    {
        //saving new invoice to partner balance
        $this->partner->total_invoiced_eur += $this->orderAmountEur;
        $this->partner->save();
        
        //saving new invoice to partner's card
        $this->card->card_invoiced_eur += $this->orderAmountEur;
        $this->card->save();
        
        //savingCardIdToOrder
        $this->order->payment_card_id = $this->card->id;
        $this->order->save();
    }
    #endregion
}