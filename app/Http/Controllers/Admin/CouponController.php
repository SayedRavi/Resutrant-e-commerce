<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\CouponDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CreateCouponeRequest;
use App\Models\Coupon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CouponController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(CouponDataTable $dataTable)
    {
        return $dataTable->render('admin.coupon.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.coupon.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateCouponeRequest $request)
    {

        Coupon::create([
            'name' => $request->name,
            'code' => $request->code,
            'quantity' => $request->quantity,
            'min_purchase_amount' => $request->min_purchase_amount,
            'expire_date' => $request->expire_date,
            'discount_type' => $request->discount_type,
            'discount' => $request->discount,
            'status' => $request->status
        ]);
        \Flasher\Toastr\Prime\toastr()->success('Coupon added successfully');
        return redirect()->route('admin.coupon.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $coupon = Coupon::findOrFail($id);
        return view('admin.coupon.edit', compact('coupon'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $coupon = Coupon::findOrFail($id);
        $coupon->update([
            'name' => $request->name,
            'code' => $request->code,
            'quantity' => $request->quantity,
            'min_purchase_amount' => $request->min_purchase_amount,
            'expire_date' => $request->expire_date,
            'discount_type' => $request->discount_type,
            'discount' => $request->discount,
            'status' => $request->status
        ]);
        \Flasher\Toastr\Prime\toastr()->success('Coupon added successfully');
        return redirect()->route('admin.coupon.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $coupon = Coupon::findOrFail($id);
        try {
            $coupon->delete();
                return response(['message' => 'Coupon deleted successfully', 'status' => 'success']);
        }catch (\Exception $error){
            return response(['message' => $error->getMessage(), 'status' => 'error']);
        }
    }
}
