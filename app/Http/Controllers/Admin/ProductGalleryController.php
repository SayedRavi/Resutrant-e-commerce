<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductGallery;
use App\Traits\FileUploadTrait;
use Illuminate\Http\Request;

class ProductGalleryController extends Controller
{
    Use FileUploadTrait;
    /**
     * Display a listing of the resource.
     */
    public function index(String $productID)
    {
        $images = ProductGallery::where('product_id', $productID)->get();
        $product = Product::findOrFail($productID);
        return view('admin.product.gallery.index', compact('product', 'images'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
       $data = $request->validate([
           'image' => ['required', 'image', 'max:5000'],
           'product_id' => ['required', 'integer']
       ]);
       $imagePath = $this->uploadImage($request, 'image');
       ProductGallery::create([
           'image' => $imagePath,
           'product_id' => $data['product_id']
       ]);
       toastr('Added Successfully.', 'success');
       return redirect()->back();

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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $image = ProductGallery::findOrFail($id);
            $this->removeImage($image->image);
            $image->delete();
            return response(['message'=>'Deleted Successfully', 'status'=> 'success']);
        }
        catch (\Exception $error){
            return response(['message'=>'Something Went Wrong', 'status'=> 'error']);

        }
    }
}
