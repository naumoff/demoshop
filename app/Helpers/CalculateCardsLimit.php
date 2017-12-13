<?php
/**
 * Created by PhpStorm.
 * User: Sergey
 * Date: 07.12.2017
 * Time: 17:41
 */

namespace App\Helpers;

use App\PaymentPartner;

trait CalculateCardsLimit
{
    public function saveTotalCardsLimitAmount($partnerId)
    {
        $partner = PaymentPartner::find($partnerId);
        
        $totalCardsLimit = 0;
        foreach ($partner->paymentCards()->where('active','=',1)->get() AS $card){
            $totalCardsLimit += $card->card_limit_eur;
        }
        
        $partner->total_cards_limit_eur = $totalCardsLimit;
        $partner->save();
        
        return $partner->total_cards_limit_eur;
    }
}