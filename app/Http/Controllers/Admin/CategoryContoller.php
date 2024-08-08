<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\CategoryDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminCategoryRequest;
use App\Http\Requests\Admin\AdminCategoryUpdateRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Psy\Util\Str;
use function Laravel\Prompts\password;

class CategoryContoller extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(CategoryDataTable $dataTable)
    {
        return $dataTable->render('admin.product.category.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.product.category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AdminCategoryRequest $request)
    {
        $slug = \Illuminate\Support\Str::slug($request->name);
        Category::create([
            'name' => $request->name,
            'slug' => $slug,
            'show_at_home' => $request->show_at_home,
            'status' => $request->status,
        ]);
        toastr('Created Successfully', 'success');
        return redirect()->route('admin.category.index');
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
        $item = Category::findOrFail($id);
        return view('admin.product.category.edit', compact('item'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AdminCategoryUpdateRequest $request, string $id)
    {
        $category  = Category::findOrFail($id);
        $category->update([
            'name' => $request->name,
            'show_at_home'=> $request->show_at_home,
            'status' => $request->status
        ]);
        toastr('Updated Successfully', 'success');
        return redirect()->route('admin.category.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $item = Category::findOrFail($id);
            $item->delete();
            return response(['message'=> 'Deleted Successfully', 'status' => 'success']);
        }
        catch (\Exception $error){
            return  response(['message'=> 'Something Went Wrong', 'status' => 'error']);
        }


    }
}
