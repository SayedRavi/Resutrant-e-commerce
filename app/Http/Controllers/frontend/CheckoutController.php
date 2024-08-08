<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Adress;
use App\Models\DeliveryArea;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function index()
    {
        $user_addresses = Adress::where('user_id', auth()->user()->id)->get();
        $delivery_areas = DeliveryArea::where('status' , 1)->get();
        return view('frontend.pages.checkout', compact('user_addresses', 'delivery_areas'));
    }

    public function deliveryCalculation(string $id)
    {
        try {
            $address = Adress::findOrFail($id);
            $deliveryFee = $address->deliveryArea?->delivery_fee;
            $grandTotal = grandCartTotal($deliveryFee);
            return response(['delivery_fee' => $deliveryFee, 'grandTotal' => $grandTotal]);
        } catch (\Exception $exception) {
            return response(['message' => 'Sorry something went wrong!']);
        }
    }

    public function checkoutRedirect(Request $request)
    {
        $request->validate([
            'id' => 'required', 'integer'
        ]);
        $address = Adress::with(['deliveryArea'])->findOrFail($request->id);
        $selectedAddress = $address->address.','.$address->deliveryArea?->area_name;
        session()->put('address', $selectedAddress);
        session()->put('address_id', $address->id);
        session()->put('delivery_fee', $address->deliveryArea->delivery_fee);
        return response(['redirect_url'=> route('payment.index')]);
    }
}
