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
        $this->setCurrentPartner();
        do{
            if($this->checkPartnerLimitWithOrderAmount() === false){
                //limit reached, partner rotated
                $this->rotatePaymentPartner();
            }
        }while($this->checkPartnerLimitWithOrderAmount() === false);
    
        //store data to current Partner and current Card
        $this->setCurrentCard();
        dump($this->partner);
        dd($this->card);
        dd(88);
        do{
            if($this->checkCardLimitWithOrderAmount() === false){
                //limit reached, partner rotated
                $this->rotatePaymentCard();
            }
        }while($this->checkCardLimitWithOrderAmount() === false);
    
        $this->addOrderAmountToPartner();
        
    }
    #endrgion
    
    #region SERVICE METHODS
    private function setCurrentPartner()
    {
        $currentPartner = PaymentPartner::active()->current()->first();

        if ($currentPartner === null) {
            $currentPartner = PaymentPartner::active()->bySequence()->first();
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

        do{
            $this->partner = PaymentPartner::active()
                ->bySequence()
                ->next($this->partner->sequence, $this->partner->id)
                ->withinEurLimit($this->orderAmountEur)
                ->with('paymentCards')
                ->first();
            
            if($this->partner === null){
                $this->setCurrentPartner();
            }
            
            $status = false;
            
            foreach ($this->partner->paymentCards AS $paymentCard){
                if($paymentCard->active == 1
                    && $paymentCard->card_limit_eur > $this->orderAmountEur){
                    $status = true;
                    break;
                }
            }
        }while($status === true);
        
        $this->partner->current = 1;
        $this->partner->save();
    }
    private function cleanPostCurrentPartnerData()
    {
        //cleaning data for post current partner
        $this->partner->current = 0;
        $this->partner->total_invoiced_eur = 0;
        $this->partner->save();
        foreach ($this->partner->paymentCards AS $paymentCard) {
            $paymentCard->card_invoiced_eur = 0;
            $paymentCard->current = 0;
            $paymentCard->save();
        }
    }
    private function setCurrentCard()
    {
        $currentCard = $this->partner->paymentCards()->active()->current()->first();
        
        if ($currentCard === null) {
            $currentCard = $this->partner->paymentCards()->active()->byId()->first();
            PaymentCard::where('current','=',1)->update(['current'=>0]);
            $currentCard->current = 1;
            $currentCard->save();
        }
        $this->card = $currentCard;
        return $currentCard;
    }
    
    #endregion
}