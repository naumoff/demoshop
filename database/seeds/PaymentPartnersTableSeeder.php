<?php

use Illuminate\Database\Seeder;

class PaymentPartnersTableSeeder extends Seeder
{
    private $partnersQtyLimit = 50;
    private $cardsQtyLimit = 9;
    
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->generatePartnersWithCards($this->partnersQtyLimit);
    }
    
    #region SERVICE METHODS
    private function generatePartnersWithCards($partnersQtyLimit)
    {
        for($a = 0; $a < $partnersQtyLimit; $a++){
            $partnerId = factory(\App\PaymentPartner::class)->create()->id;
            
            $cardsQtyLimit = rand(1,$this->cardsQtyLimit);
            
            for($cards = 0; $cards < $cardsQtyLimit; $cards++){
                factory(\App\PaymentCard::class)->create([
                    'holder_id'=>$partnerId,
                ]);
            }
        }
    }
    #endregion
}
