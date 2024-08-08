<?php

namespace App\Http\Controllers;

use App\DataTables\BlogCategoryDataTable;
use App\Models\BlogCategory;
use App\Models\Slider;
use Illuminate\Http\Request;

class BlogCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(BlogCategoryDataTable $dataTable)
    {
        return $dataTable->render('admin.blog.blog-category.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.blog.blog-category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|unique:blog_categories,name',
            'status' => 'required|boolean',
        ]);
        BlogCategory::create([
            'name' => $data['name'],
            'slug' => \Str::slug($data['name']),
            'status' => $data['status'],
        ]);
        toastr()->success('Category added successfully!');
        return redirect()->route('admin.blog-category.index');
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
        $category = BlogCategory::findOrFail($id);
        return view('admin.blog.blog-category.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $category = BlogCategory::findOrFail($id);
        $data = $request->validate([
            'name' => 'required|unique:blog_categories,name',
            'status' => 'required|boolean',
        ]);
        $category->update([
            'name' => $data['name'],
            'slug' => \Str::slug($data['name']),
            'status' => $data['status'],
        ]);
        toastr()->success('Category Updated successfully!');
        return redirect()->route('admin.blog-category.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $category = BlogCategory::findOrFail($id);
            $category->delete();
            return response(['status'=>'success', 'message' => 'Deleted Successfully']);
        }catch (\Exception $exception){
            return response(['status' => 'error', 'message' => 'Something Went Wrong!']);
        }
    }
}
