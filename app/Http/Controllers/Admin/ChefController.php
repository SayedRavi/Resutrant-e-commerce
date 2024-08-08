<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\ChefDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ChefCreateRequest;
use App\Http\Requests\Admin\ChefUpdateRequest;
use App\Models\Chef;
use App\Models\SectionTitle;
use App\Models\Slider;
use App\Traits\FileUploadTrait;
use Illuminate\Http\Request;
use function Termwind\render;

class ChefController extends Controller
{
    use FileUploadTrait;
    public function index(ChefDataTable $dataTable)
    {
        $keys = ['chefs_section_top_title', 'chefs_section_main_title', 'chefs_section_sub_title'];
        $title = SectionTitle::whereIn('key', $keys)->pluck('value', 'key');
        return $dataTable->render('admin.chef.index', compact('title'));
    }
    public function create(){
        return view('admin.chef.create');
    }

    public function store(ChefCreateRequest $request)
    {
        $imagePath = $this->uploadImage($request, 'image');
        Chef::create([
            'image' => $imagePath,
            'name' => $request->name,
            'title' => $request->title,
            'fb' => $request->fb,
            'in' => $request->in,
            'x' => $request->x,
            'web' => $request->web,
            'show_at_home' => $request->show_at_home,
            'status' => $request->status,
        ]);

        toastr()->success('Created Successfully');
        return redirect(route('admin.chef.index'));
    }

    public function edit(string $id)
    {
        $chef = Chef::findOrFail($id);
        return view('admin.chef.edit', compact('chef'));
    }

    public function update(ChefUpdateRequest $request,string $id)
    {
        $chef = Chef::findOrFail($id);
        $imagePath = $this->uploadImage($request, 'image', $request->old_image);
        $chef->update([
            'image' => !empty($imagePath) ? $imagePath : $request->old_image,
            'name' => $request->name,
            'title' => $request->title,
            'fb' => $request->fb,
            'in' => $request->in,
            'x' => $request->x,
            'web' => $request->web,
            'show_at_home' => $request->show_at_home,
            'status' => $request->status,
        ]);

        toastr()->success('Updated Successfully');
        return redirect(route('admin.chef.index'));
    }


    public function updateTitle(Request $request)
    {

        $data = $request->validate([
            'chefs_section_top_title' => [ 'max:100'],
            'chefs_section_main_title' => [ 'max:100'],
            'chefs_section_sub_title' => [ 'max:500'],
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

    public function destroy(string $id)
    {
        try {
            $chef = Chef::findOrFail($id);
            $this->removeImage($chef->image);
            $chef->delete();
            return response(['status'=>'success', 'message' => 'Deleted Successfully']);
        }catch (\Exception $exception){
            return response(['status' => 'error', 'message' => 'Something Went Wrong!']);
        }
    }
}
