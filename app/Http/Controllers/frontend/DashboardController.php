<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\AdressCreateRequest;
use App\Http\Requests\Frontend\AdressUpdateRequest;
use App\Models\Adress;
use App\Models\DeliveryArea;
use App\Models\Order;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $delivery_areas = DeliveryArea::where('status', 1)->get();
        $userAddress = Adress::where('user_id', auth()->user()->id)->get();
        $orders = Order::where('user_id', auth()->user()->id)->get();
        return view('frontend.dashboard.index', compact('delivery_areas', 'userAddress', 'orders'));
    }

    public function storeAddress(AdressCreateRequest $request)
    {

        Adress::create([
            'user_id' => auth()->user()->id,
            'delivery_area_id' => $request->delivery_area_id,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'type' => $request->type
        ]);
        \Flasher\Toastr\Prime\toastr()->success('Address Added Successfully');
        return redirect()->back();
    }

    public function updateAddress(string $id, AdressUpdateRequest $request)
    {
        $address = Adress::findOrFail($id);
        $address->update([
            'user_id' => auth()->user()->id,
            'delivery_area_id' => $request->delivery_area_id,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'type' => $request->type
        ]);
        \Flasher\Toastr\Prime\toastr()->success('Address Updated Successfully');
        return redirect()->back();
    }

    public function deleteAddress(string $id)
    {
        $address = Adress::findOrFail($id);
        if ($address && $address->user_id == auth()->user()->id){
            $address->delete();
            return response(['message' => 'Deleted Successfully', 'status' => 'success']);
        }
        return response(['message' => 'Something Went Wrong!', 'status' => 'error']);

    }
}
