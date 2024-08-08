<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\ProductDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProductCreateRequest;
use App\Http\Requests\Admin\ProductUpdateRequest;
use App\Models\Category;
use App\Models\Product;
use App\Traits\FileUploadTrait;
use Illuminate\Http\Request;
use mysql_xdevapi\Exception;

class ProductController extends Controller
{
    Use FileUploadTrait;
    /**
     * Display a listing of the resource.
     */
    public function index(ProductDataTable $dataTable)
    {
        return $dataTable->render('admin.product.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin.product.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductCreateRequest $request)
    {
        $imagePath = $this->uploadImage($request, 'image');
        Product::create([
            'thumb_image' => $imagePath,
            'name' => $request->name,
            'slug' => generateUniqueSlug('Product', $request->name),
            'category_id' => $request->category,
            'price' => $request->price,
            'offer_price' => $request->Offer_price ?? 0,
            'quantity' => $request->quantity,
            'short_description' => $request->short_description,
            'long_description' => $request->long_description,
            'sku' => $request->sku,
            'seo_title' => $request->seo_title,
            'seo_description' => $request->seo_description,
            'show_at_home' => $request->show_at_home,
            'status' => $request->status
        ]);
        toastr('Created Successfully', 'success');
        return redirect()->route('admin.product.index');
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
        $product = Product::findOrFail($id);
        $categories = Category::all();
        return view('admin.product.edit',compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductUpdateRequest $request, string $id)
    {
        $product = Product::findOrFail($id);
        $imagePath = $this->uploadImage($request, 'image', $product->thumb_image);
        $product->update([
            'thumb_image' => !empty($imagePath) ? $imagePath : $product->thumb_image,
            'name' => $request->name,
            'category_id' => $request->category,
            'price' => $request->price,
            'offer_price' => $request->offer_price ?? 0,
            'quantity' => $request->quantity,
            'short_description' => $request->short_description,
            'long_description' => $request->long_description,
            'sku' => $request->sku,
            'seo_title' => $request->seo_title,
            'seo_description' => $request->seo_description,
            'show_at_home' => $request->show_at_home,
            'status' => $request->status
        ]);
        toastr('Updated Successfully', 'success');
        return redirect()->route('admin.product.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $product = Product::findOrFail($id);
            $this->removeImage($product->thumb_image);
            $product->delete();
            return response(['message'=> 'Deleted Successfully', 'status' => 'success']);
        }
        catch (\Exception $error){
            return response(['message' => 'Something Went Wrong!', 'status'=> 'error']);
        }
    }
}
