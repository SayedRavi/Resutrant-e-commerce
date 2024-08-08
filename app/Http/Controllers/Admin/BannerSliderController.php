<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\BannerSliderDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BannerSliderCreateRequest;
use App\Http\Requests\Admin\BannerSliderUpdateRequest;
use App\Models\BannerSlider;
use App\Models\Slider;
use App\Traits\FileUploadTrait;
use Illuminate\Http\Request;

class BannerSliderController extends Controller
{
    use FileUploadTrait;
    /**
     * Display a listing of the resource.
     */
    public function index(BannerSliderDataTable $dataTable)
    {
        return $dataTable->render('admin.banner-slider.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.banner-slider.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BannerSliderCreateRequest $request)
    {
       $imagePath = $this->uploadImage($request, 'image');
        BannerSlider::create([
            'banner' => $imagePath,
            'title' => $request->title,
            'subtitle' => $request->subtitle,
            'url' => $request->url,
            'status' => $request->status
        ]);
       toastr()->success('Created Successfully');
       return redirect(route('admin.banner-slider.index'));
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
        $bannerSlider  = BannerSlider::findOrFail($id);
        return view('admin.banner-slider.edit', compact('bannerSlider'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BannerSliderUpdateRequest $request, string $id)
    {
        $bannerSlider = BannerSlider::findOrFail($id);
        $imagePath = $this->uploadImage($request, 'image', $request->old_image);
        $bannerSlider->update([
            'banner' => !empty($imagePath) ? $imagePath : $request->old_image,
            'title' => $request->title,
            'subtitle' => $request->subtitle,
            'url' => $request->url,
            'status' => $request->status
        ]);
        toastr()->success('Updated Successfully');
        return redirect(route('admin.banner-slider.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $slider = BannerSlider::findOrFail($id);
            $this->removeImage($slider->image);
            $slider->delete();
            return response(['status'=>'success', 'message' => 'Deleted Successfully']);
        }catch (\Exception $exception){
            return response(['status' => 'error', 'message' => 'Something Went Wrong!']);
        }
    }
}
