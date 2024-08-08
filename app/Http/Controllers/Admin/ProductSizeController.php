<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductOption;
use App\Models\ProductSize;
use Illuminate\Http\Request;

class ProductSizeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(String $productID)
    {
        $product = Product::findOrFail($productID);
        $sizes = ProductSize::where('product_id', $product->id)->get();
        $options = ProductOption::where('product_id', $product->id)->get();
         return view('admin.product.product-size.index', compact('product','sizes', 'options'));
    }


    public function store(Request $request)
    {
        $data = $request->validate([
            'product_id' => ['required'],
            'name' => ['required', 'string', 'max:255'],
            'price' => ['required', 'numeric']
        ]);
        ProductSize::create($data);

        toastr('Created Successfully', 'success');
        return redirect()->back();

    }

    public function destroy(string $id)
    {
        try {
            $product = ProductSize::findOrFail($id);
            $product->delete();
            return response(['message' => 'Deleted Successfully', 'status'=> 'success']);
        }
        catch (\Exception $error){
            return response(['message' => 'Something Went Wrong!', 'status'=> 'error']);

        }
    }
}
