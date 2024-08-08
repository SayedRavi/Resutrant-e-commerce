<?php

namespace App\Listeners;

use App\Events\OrderPaymentUpdateEvent;
use App\Models\Order;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class OrderPaymentUpdateListener
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
    public function handle(OrderPaymentUpdateEvent $event): void
    {
        $orderId = $event->orderId;
        $order = Order::find($orderId);
        $order->update([
            'payment_method' => $event->paymentMethod,
            'payment_status' => $event->paymentInfo['status'],
            'payment_approve_date' => now(),
            'transaction_id' => $event->paymentInfo['transaction_id'],
            'currency_name' => $event->paymentInfo['currency']
        ]);
    }
}
