<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class OrderPaymentUpdateEvent implements ShouldQueue
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $orderId;
    public $paymentMethod;
    public $paymentInfo;

    /**
     * Create a new event instance.
     */
    public function __construct($orderId, $paymentInfo, $paymentMethod)
    {
        //
        $this->orderId = $orderId;
        $this->paymentMethod = $paymentMethod;
        $this->paymentInfo = $paymentInfo;
    }


    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('channel-name'),
        ];
    }
}
