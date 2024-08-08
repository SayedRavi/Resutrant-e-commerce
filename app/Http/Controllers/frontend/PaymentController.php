<?php

namespace App\Http\Controllers\Frontend;

use App\Events\OrderPaymentUpdateEvent;
use App\Events\OrderPlacedNotificationEvent;
use App\Events\RTOrderPlacedNotificationEvent;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\services\OrderService;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use Stripe\Stripe;
use Stripe\Checkout\Session as StripeCheckoutSession;

class PaymentController extends Controller
{
    public function index()
    {
        if (! session()->has('delivery_fee') && ! session()->has('address')){
            throw ValidationException::withMessages(['Sorry Something went wrong!']);
        }
        $subTotal = cartTotal();
        $delivery = session()->get('delivery_fee') ?? 0;
        $discount = session()->get('coupon')['discount'] ?? 0;
        $grandTotal = grandCartTotal($delivery);
        return view('frontend.pages.payment', compact('subTotal', 'delivery', 'discount', 'grandTotal'));
    }

    // -------------Success and Cancel Views -----------------------------//
     function paymentSuccess()
    {
        return view('frontend.pages.payment-success');
    }

     function paymentCancel()
    {
        return view('frontend.pages.payment-cancel');
    }
    //--------------------------------------------------------------------//

    //------Payment Methods -----------------------------------------------//
     function makePayment(Request $request, OrderService $orderService)
    {

        $request->validate([
            'payment_gateway' => ['required', 'string', 'in:paypal,stripe']
        ]);

        if ($orderService->createOrder()){
            switch ($request->payment_gateway){
                case 'paypal':
                    return response(['redirect_url' => route('paypal.payment')]);
                    break;
                case 'stripe':
                    return response(['redirect_url' => route('stripe.payment')]);

                default:
                    abort(404);
                    break;
            }
        }
    }
    //-------------------------------------------------------------------------------//

    //------PayPal Payment ----------------------------------------------------------//
     function setPaypalConfig()
    {
        $config = [
            'mode'    => config('gatewaySettings.paypal_account_mode'), // Can only be 'sandbox' Or 'live'. If empty or invalid, 'live' will be used.
            'sandbox' => [
                'client_id'         => config('gatewaySettings.paypal_api_key'),
                'client_secret'     => config('gatewaySettings.paypal_secret_key'),
                'app_id'            => 'APP-80W284485P519543T',
            ],
            'live' => [
                'client_id'         => config('gatewaySettings.paypal_api_key'),
                'client_secret'     => config('gatewaySettings.paypal_secret_key'),
                'app_id'            => config('gatewaySettings.paypal_app_id'),
            ],

            'payment_action' => 'Sale', // Can only be 'Sale', 'Authorization' or 'Order'
            'currency'       => config('gatewaySettings.paypal_currency_name'),
            'notify_url'     => env('PAYPAL_NOTIFY_URL', ''), // Change this accordingly for your application.
            'locale'         => 'en_US', // force gateway language  i.e. it_IT, es_ES, en_US ... (for express checkout only)
            'validate_ssl'   => true, // Validate SSL when creating api client.
        ];
        return $config;
    }
     function paypalPayment()
    {
        $config = $this->setPaypalConfig();
        $provider = new PayPalClient($config);
        $provider->getAccessToken();

        //Calculate Payable amount
        $grandTotal = session()->get('grand_total');
        $payableAmount = round($grandTotal * config('gatewaySettings.paypal_rate'));

        $response = $provider->createOrder([
            'intent' => "CAPTURE",
            'application_context' => [
                'return_url' => route('paypal.success'),
                'cancel_url' => route('paypal.cancel')
            ],
            'purchase_units' =>[
                [
                    'amount'=> [
                        'currency_code' => config('gatewaySettings.paypal_currency_name'),
                        'value' => $payableAmount
                    ]
                ]
            ]
        ]);
        if (isset($response['id']) && $response['id']!=null){
            foreach($response['links'] as $link){
                if ($link['rel'] === 'approve'){
                    return redirect()->away($link['href']);
                }
            }
        }else{
            return redirect()->route('payment.cancel')->withErrors(['error' => $response['error']['message']]);
        }
    }

     function paypalSuccess(Request $request, OrderService $orderService)
    {
        $config = $this->setPaypalConfig();
        $provider = new PayPalClient($config);
        $provider->getAccessToken();

       $response = $provider->capturePaymentOrder($request->token);

       if (isset($response['status']) && $response['status'] === 'COMPLETED'){
           $orderId = session()->get('order_id');
           $capture = $response['purchase_units'][0]['payments']['captures'][0];
           $paymentInfo = [
               'transaction_id' => $capture['id'],
               'currency' => $capture['amount']['currency_code'],
               'status' => strtolower($capture['status']),
           ];

           OrderPaymentUpdateEvent::dispatch($orderId, $paymentInfo, 'PayPal');
           OrderPlacedNotificationEvent::dispatch($orderId);
           RTOrderPlacedNotificationEvent::dispatch(Order::find($orderId));


//           Clear Session
           $orderService->clearSession();
           return redirect()->route('payment.success');
       }else{
           $this->transactionFailUpdateStatus('PayPal');
           return redirect()->route('payment.cancel')->withErrors(['error' => $response['error']['message']]);

       }
    }

     function paypalCancel()
    {
        return redirect()->route('payment.cancel');
    }
//-------------------------------------------------------------------------------------//


//    Stripe Payment -------------------------------------------------------------------//
    function stripePayment()
    {
        Stripe::setApiKey(config('gatewaySettings.stripe_secret_key'));
        //Calculate Payable amount
        $grandTotal = session()->get('grand_total');
        $payableAmount = round($grandTotal * config('gatewaySettings.stripe_rate')) * 100;

        $response = StripeCheckoutSession::create([
            'line_items' => [
                [
                    'price_data' => [
                        'currency' => config('gatewaySettings.stripe_currency_name'),
                        'product_data' => [
                            'name' => 'product'
                        ],
                        'unit_amount' => $payableAmount
                    ],
                    'quantity' => 1
                ]
            ],
            'mode' => 'payment',
            'success_url' => route('stripe.success') . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('stripe.cancel')
        ]);

        return redirect()->away($response->url);
    }

    function stripeSuccess(Request $request, OrderService $orderService)
    {
        $sessionId = $request->session_id;
        Stripe::setApiKey(config('gatewaySettings.stripe_secret_key'));
        $response = StripeCheckoutSession::retrieve($sessionId);
        if ($response->payment_status === 'paid'){
            $orderId = session()->get('order_id');

            $paymentInfo = [
                'transaction_id' => $response->payment_intent,
                'currency' => $response->currency,
                'status' => strtolower($response->payment_status),
            ];

            OrderPaymentUpdateEvent::dispatch($orderId, $paymentInfo, 'Stripe');
            OrderPlacedNotificationEvent::dispatch($orderId);
            RTOrderPlacedNotificationEvent::dispatch(Order::find($orderId));


//           Clear Session
            $orderService->clearSession();
            return redirect()->route('payment.success');
        }else{
            $this->transactionFailUpdateStatus('Stripe');
            return redirect()->route('payment.cancel');

        }

    }
    function stripeCancel(){
        return 'cancel';
    }
    function transactionFailUpdateStatus($gatewayName)
    {

        $orderId = session()->get('order_id');
        $paymentInfo = [
            'transaction_id' => '',
            'currency' => '',
            'status' => 'Failed',
        ];

        OrderPaymentUpdateEvent::dispatch($orderId, $paymentInfo, $gatewayName);
    }
}
