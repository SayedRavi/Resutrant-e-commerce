<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\TestimonialDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\TestimonialCreateRequest;
use App\Models\SectionTitle;
use App\Models\Slider;
use App\Models\Testimoinal;
use App\Traits\FileUploadTrait;
use Illuminate\Http\Request;

class TestimonialController extends Controller
{
    use FileUploadTrait;
    /**
     * Display a listing of the resource.
     */
    public function index(TestimonialDataTable $dataTable)
    {
        $keys = ['testimonial_section_top_title', 'testimonial_section_main_title', 'testimonial_section_sub_title'];
        $title = SectionTitle::whereIn('key', $keys)->pluck('value', 'key');
        return $dataTable->render('admin.testimonial.index', compact('title'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.testimonial.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TestimonialCreateRequest $request)
    {
        $imagePath = $this->uploadImage($request, 'image');
        Testimoinal::create([
            'image' => !empty($imagePath) ? $imagePath : null,
            'name' => $request->name,
            'title' => $request->title,
            'review' => $request->review,
            'rating' => $request->rating,
            'show_at_home' => $request->show_at_home,
            'status' => $request->status
        ]);
        toastr()->success('Created Successfully');
        return redirect()->route('admin.testimonial.index');
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
        $testimonial = Testimoinal::findOrFail($id);
        return view('admin.testimonial.edit', compact('testimonial'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $testimonial = Testimoinal::findOrFail($id);
        $imagePath = $this->uploadImage($request, 'image', $request->old_image);
        $testimonial->update([
            'image' => !empty($imagePath) ? $imagePath : $request->old_image,
            'name' => $request->name,
            'title' => $request->title,
            'review' => $request->review,
            'rating' => $request->rating,
            'show_at_home' => $request->show_at_home,
            'status' => $request->status
        ]);
        toastr()->success('Updated Successfully');
        return redirect()->route('admin.testimonial.index');
    }

    public function updateTitle(Request $request)
    {
        $data = $request->validate([
            'testimonial_section_top_title' => [ 'max:100'],
            'testimonial_section_main_title' => [ 'max:100'],
            'testimonial_section_sub_title' => [ 'max:500'],
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
            $testimonial = Testimoinal::findOrFail($id);
            $this->removeImage($testimonial->image);
            $testimonial->delete();
            return response(['status'=>'success', 'message' => 'Deleted Successfully']);
        }catch (\Exception $exception){
            return response(['status' => 'error', 'message' => 'Something Went Wrong!']);
        }
    }
}
