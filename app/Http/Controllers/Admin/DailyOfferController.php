<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\DailyOfferDataTable;
use App\Http\Controllers\Controller;
use App\Models\DailyOffer;
use App\Models\Product;
use App\Models\SectionTitle;
use App\Models\Slider;
use Illuminate\Http\Request;

class DailyOfferController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(DailyOfferDataTable $dataTable)
    {
        $keys = ['daily_offer_top_title', 'daily_offer_main_title', 'daily_offer_sub_title'];
        $title = SectionTitle::whereIn('key', $keys)->pluck('value', 'key');
        return $dataTable->render('admin.daily-offer.index', compact('title'));
    }

    public function searchProduct(Request $request)
    {
        $product = Product::select('id', 'name', 'thumb_image')->where('name', 'LIKE', '%'.$request->search.'%')->get();
        return response($product);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.daily-offer.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'product_id' => 'required', 'integer',
            'status' => 'required', 'boolean'
        ]);
        DailyOffer::create($data);
        toastr()->success('Created Successfully');
        return to_route('admin.daily-offer.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $dailyOffer = DailyOffer::with(['product'])->findOrFail($id);
        return view('admin.daily-offer.edit', compact('dailyOffer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'product_id' => 'required', 'integer',
            'status' => 'required', 'boolean'
        ]);
        $dailyOffer = DailyOffer::findOrFail($id);

        $dailyOffer->update($data);
        toastr()->success('Updated Successfully');
        return to_route('admin.daily-offer.index');
    }

    public function updateTitle(Request $request)
    {

        $data = $request->validate([
            'daily_offer_top_title' => [ 'max:100'],
            'daily_offer_main_title' => [ 'max:100'],
            'daily_offer_sub_title' => [ 'max:500'],
        ]);
        foreach ($data as $key => $value) {
        SectionTitle::updateOrCreate(
            ['key' => $key],
            ['value' => $value]
        );
            }


        toastr('Created Successfully', 'success');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $dailOffer = DailyOffer::findOrFail($id);
            $dailOffer->delete();
            return response(['status'=>'success', 'message' => 'Deleted Successfully']);
        }catch (\Exception $exception){
            return response(['status' => 'error', 'message' => 'Something Went Wrong!']);
        }
    }
}
