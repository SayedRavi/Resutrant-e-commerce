<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\DeliveryAreaDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CreateDeliveryAreaRequest;
use App\Models\DeliveryArea;
use Illuminate\Http\Request;
use PharIo\Version\Exception;

class DeliveryAreaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(DeliveryAreaDataTable $dataTable)
    {
        return $dataTable->render(view: 'admin.delivery-area.index');

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.delivery-area.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateDeliveryAreaRequest $request)
    {

        DeliveryArea::create($request->all());
        \Flasher\Toastr\Prime\toastr()->success('Created Successfully');
        return redirect()->route('admin.delivery-areas.index');
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
        $area = DeliveryArea::findOrFail($id);
        return view('admin.delivery-area.edit', compact('area'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CreateDeliveryAreaRequest $request, string $id)
    {
        $area = DeliveryArea::findOrFail($id);
        $area->update($request->all());
        toastr()->success('Updated Successfully');
        return redirect()->route('admin.delivery-areas.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $area = DeliveryArea::findOrFail($id);
        try {
            $area->delete();
            return response(['message' => 'Deleted Successfully', 'status' => 'success']);
        }catch (Exception $err){
            return response(['message' => 'Something Went Wrong', 'status' => 'error']);

        }
    }
}
