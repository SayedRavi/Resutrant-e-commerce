<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PaymentGatewaySetting;
use App\Models\Setting;
use App\Providers\PaymentGatewaySettingServiceProvider;
use App\Traits\FileUploadTrait;
use Illuminate\Http\Request;

class PaymentGatewaySettingController extends Controller
{
    use FileUploadTrait;
    public function index()
    {
        $paymentGateway = PaymentGatewaySetting::pluck('value','key');
        return view('admin.payment-setting.index', compact('paymentGateway'));
    }

    public function paypalSettingUpdate(Request $request)
    {
        $data = $request->validate([
            'paypal_status' => ['required', 'boolean'],
            'paypal_account_mode' => ['required', 'in:sandbox,live'],
            'paypal_country_name' => ['required'],
            'paypal_currency_name' => ['required'],
            'paypal_rate' => ['required', 'numeric'],
            'paypal_api_key' => ['required'],
            'paypal_secret_key' => ['required'],
            'paypal_app_id' => ['required'],
        ]);
        if ($request->hasFile('paypal_logo')){
            $request->validate([
                'paypal_logo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg']
            ]);
            $imagePath = $this->uploadImage($request, 'paypal_logo');
            PaymentGatewaySetting::updateOrCreate(
                ['key' => 'paypal_logo'],
                ['value' => $imagePath],
            );
        }
        foreach ($data as $key => $value) {
            PaymentGatewaySetting::updateOrCreate(
                ['key' => $key],
                ['value' => $value],
            );
        }
        $paymentGateSetting = app(\App\Services\PaymentGatewaySetting::class);
        $paymentGateSetting->clearCachedSettings();

        toastr()->success('Payment Setting Updated Successfully');
        return redirect()->back();
    }

    public function stripeSettingUpdate(Request $request)
    {
        $data = $request->validate([
            'stripe_status' => ['required', 'boolean'],
            'stripe_country_name' => ['required'],
            'stripe_currency_name' => ['required'],
            'stripe_rate' => ['required', 'numeric'],
            'stripe_api_key' => ['required'],
            'stripe_secret_key' => ['required'],
        ]);
        if ($request->hasFile('stripe_logo')){
            $request->validate([
                'stripe_logo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg']
            ]);
            $imagePath = $this->uploadImage($request, 'stripe_logo');
            PaymentGatewaySetting::updateOrCreate(
                ['key' => 'stripe_logo'],
                ['value' => $imagePath],
            );
        }
        foreach ($data as $key => $value) {
            PaymentGatewaySetting::updateOrCreate(
                ['key' => $key],
                ['value' => $value],
            );
        }
        $paymentGateSetting = app(\App\Services\PaymentGatewaySetting::class);
        $paymentGateSetting->clearCachedSettings();

        toastr()->success('Payment Setting Updated Successfully');
        return redirect()->back();
    }

//    function razorpaySettingUpdate(Request $request)
//    {
//        $data = $request->validate([
//            'razorpay_status' => ['required', 'boolean'],
//            'razorpay_country_name' => ['required'],
//            'razorpay_currency_name' => ['required'],
//            'razorpay_rate' => ['required', 'numeric'],
//            'razorpay_api_key' => ['required'],
//            'razorpay_secret_key' => ['required'],
//        ]);
//        if ($request->hasFile('razorpay_logo')){
//            $request->validate([
//                'razorpay_logo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg']
//            ]);
//            $imagePath = $this->uploadImage($request, 'razorpay_logo');
//            PaymentGatewaySetting::updateOrCreate(
//                ['key' => 'razorpay_logo'],
//                ['value' => $imagePath],
//            );
//        }
//        foreach ($data as $key => $value) {
//            PaymentGatewaySetting::updateOrCreate(
//                ['key' => $key],
//                ['value' => $value],
//            );
//        }
//        $paymentGateSetting = app(\App\Services\PaymentGatewaySetting::class);
//        $paymentGateSetting->clearCachedSettings();
//
//        toastr()->success('Payment Setting Updated Successfully');
//        return redirect()->back();
//    }
}
