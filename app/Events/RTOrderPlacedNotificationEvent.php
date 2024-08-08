<?php

namespace App\Events;

use App\Models\Order;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class RTOrderPlacedNotificationEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $orderId;
    public $message;
    public $dates;
    /**
     * Create a new event instance.
     */
    public function __construct(Order $order)
    {
//        $this->setConfig();
        $this->orderId = $order->id;
        $this->message = '#'.$order->invoice_id.' a new Order has been placed';
        $this->dates = date('h:i A | d-F-Y', strtotime($order->created_at));
    }

//    function setConfig()
//    {
//        config(['broadcasting.connections.pusher.key'=> config('settings.pusher_key')]);
//        config(['broadcasting.connections.pusher.secret'=> config('settings.pusher_secret')]);
//        config(['broadcasting.connections.pusher.app_id'=> config('settings.pusher_app_id')]);
//        config(['broadcasting.connections.pusher.options.cluster'=> config('settings.pusher_cluster')]);
//    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new Channel('orderPlaced'),
        ];
    }

}
