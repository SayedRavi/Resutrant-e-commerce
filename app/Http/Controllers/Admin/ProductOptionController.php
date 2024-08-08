<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductOption;
use Illuminate\Http\Request;

class ProductOptionController extends Controller
{

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'price' => ['required', 'numeric'],
            'product_id' => ['required', 'integer']
        ],[
            'name.required' => 'Product Option Name is Required',
            'name.max' => 'Product Option max length is 255 Characters',
            'price.required' => 'Product Option Price is Required',
            'price.numeric' => 'Price Input must be type of Number'

        ]);
        ProductOption::create($data);
        toastr('Created Successfully', 'success');
        return redirect()->back();
    }


    public function destroy(string $id)
    {
        try {
            $option = ProductOption::findOrFail($id);
            $option->delete();
            return response(['message' => 'Deleted Successfully', 'status' => 'success']);
        }
        catch (\Exception $error){
            return response(['message' => 'Something Went Wrong!', 'status' => 'error']);

        }
    }
}
