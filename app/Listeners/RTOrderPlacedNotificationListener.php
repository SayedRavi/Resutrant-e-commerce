<?php

namespace App\Listeners;

use App\Events\RTOrderPlacedNotificationEvent;
use App\Models\OrderPlacedNotifaction;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class RTOrderPlacedNotificationListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(RTOrderPlacedNotificationEvent $event): void
    {
        OrderPlacedNotifaction::create([
            'message' => $event->message,
            'order_id' => $event->orderId
        ]);
    }
}
