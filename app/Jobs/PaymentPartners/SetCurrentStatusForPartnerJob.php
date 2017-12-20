<?php

namespace App\Jobs\PaymentPartners;

use App\PaymentCard;
use App\PaymentPartner;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SetCurrentStatusForPartnerJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $partner;
    private $newValue;

    /**
     * SetCurrentStatusForPartnerJob constructor.
     * @param PaymentPartner $partner
     * @param int $oldValue
     */
    public function __construct(PaymentPartner $partner, int $oldValue)
    {
        $this->partner = $partner;
        if($oldValue === 0){
            $this->newValue = 1;
        }elseif($oldValue === 1){
            $this->newValue = 0;
        }
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if($this->newValue === 0){
            $this->setPartnerToNonCurrent();
        }elseif($this->newValue === 1){
            $this->setPartnerToCurrent();
        }
    }

    private function setPartnerToNonCurrent()
    {
        //deactivate partner
        $this->partner->current = 0;

        //clean partner's total invoices
        $this->partner->total_invoiced_eur = 0;
        $this->partner->save();

        //clean partner's card total invoices
        PaymentCard::where('holder_id','=',$this->partner->id)
            ->update(['card_invoiced_eur'=>0,'current'=>0]);
    }

    private function setPartnerToCurrent()
    {
        //deactivate all partners
        PaymentPartner::where('current','=',1)
            ->update(['current'=>0]);

        //clean all partners total invoices
        PaymentPartner::where('current','=',0)
            ->update(['total_invoiced_eur'=>0]);

        //clean all cards card total invoices and set them to non current status
        PaymentCard::where('id','>',0)->update(['current'=>0, 'card_invoiced_eur'=>0]);

        //activate selected partner
        $this->partner->current = 1;
        $this->partner->save();
    }
}
