<?php
namespace App\services;

use App\Models\Order;
use App\Models\OrderItem;
use Gloudemans\Shoppingcart\Cart;

class OrderService{

    //Store Order in Database
    function createOrder()
    {
        try {
            $order = Order::create([
                'invoice_id' => generateInvoiceId(),
                'user_id' => auth()->user()->id,
                'address' => session()->get('address'),
                'discount' => session()->get('coupon')['discount'] ?? 0,
                'delivery_charge' => session()->get('delivery_fee'),
                'sub_total' => cartTotal(),
                'grand_total' => grandCartTotal(session()->get('delivery_fee')),
                'product_qty' => \Gloudemans\Shoppingcart\Facades\Cart::content()->count(),
                'payment_method' => null,
                'payment_status' => 'pending',
                'payment_approve_date' => null,
                'transaction_id' => null,
                'coupon_info' => json_encode(session()->get('coupon')),
                'currency_name' => null,
                'order_status' => 'pending',
                'address_id' => session()->get('address_id'),
            ]);
            foreach (\Gloudemans\Shoppingcart\Facades\Cart::content() as $product){
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_name' => $product->name,
                    'product_id' => $product->id,
                    'unit_price' => $product->price,
                    'quantity' => $product->qty,
                    'product_size' => json_encode($product->options->product_size),
                    'product_option' => json_encode($product->options->product_options),
                ]);
            }
            session()->put('order_id', $order->id);
            session()->put('grand_total', $order->grand_total);

            return true;
        }catch (\Exception $exception){
            logger ($exception);

            return false;
        }
    }

    // Clearing the session items
    function clearSession()
    {
        \Gloudemans\Shoppingcart\Facades\Cart::destroy();
        session()->forget('coupon');
        session()->forget('address');
        session()->forget('delivery_fee');
        session()->forget('delivery_area_id');
        session()->forget('oder_id');
        session()->forget('grand_total');
    }
}
