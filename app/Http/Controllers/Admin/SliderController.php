<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\SliderDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SliderCreateRequest;
use App\Http\Requests\Admin\SliderUpdateRequest;
use App\Models\Slider;
use App\Traits\FileUploadTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class SliderController extends Controller
{
    use FileUploadTrait;
    /**
     * Display a listing of the resource.
     */
    public function index(SliderDataTable $dataTable)
    {
        return $dataTable->render('admin.slider.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.slider.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SliderCreateRequest $request)
    {
        $imagePath = $this->uploadImage($request, 'image');
        $slider = Slider::create([
            'image' => $imagePath,
            'offer' => $request->offer,
            'title' => $request->title,
            'sub_title' => $request->sub_title,
            'short_description' => $request->short_description,
            'button_link' => $request->button_link,
            'status' => $request->status
        ]);
        toastr('Slider Created Successfully', 'success');
        return redirect()->route('admin.slider.index');
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
        $slider =Slider::findOrFail($id);
        return view('admin.slider.edit', compact('slider'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SliderUpdateRequest $request, string $id)
    {

        $slider = Slider::findOrFail($id);
        $image = $slider->image;
        $imagePath = $this->uploadImage($request, 'image', $image);
            $slider->update([
                'image' => !empty($imagePath) ? $imagePath : $slider->image,
                'offer' => $request->offer,
                'title' => $request->title,
                'sub_title' => $request->sub_title,
                'short_description' => $request->short_description,
                'button_link' => $request->button_link,
                'status' => $request->status
            ]);

        toastr('Slider Updated Successfully', 'success');
        return redirect()->route('admin.slider.index');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $slider = Slider::findOrFail($id);
            $this->removeImage($slider->image);
            $slider->delete();
            return response(['status'=>'success', 'message' => 'Deleted Successfully']);
        }catch (\Exception $exception){
            return response(['status' => 'error', 'message' => 'Something Went Wrong!']);
        }
    }
}
