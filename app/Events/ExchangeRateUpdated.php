<?php

namespace App\Events;

use App\CurrencyRate;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class ExchangeRateUpdated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    #region CLASS PROPERTIES
    public $currencyRate;
    #endregion
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(CurrencyRate $currencyRate)
    {
        $this->currencyRate = $currencyRate;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
