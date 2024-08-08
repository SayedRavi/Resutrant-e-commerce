<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use PharIo\Version\Exception;

class cartController extends Controller
{
    public function index()
    {
        return view('frontend.pages.cart-view');
    }
    public function addToCart(Request $request)
    {
        $product = Product::with(['productSizes','productOptions'])->findOrFail($request->product_id);
        if ($product->quantity < $request->quantity){
            throw ValidationException::withMessages(['Quantity out of stock']);
        }
        try {
            $productSize = $product->productSizes->where('id', $request->product_size)->first();
            $productOptions = $product->productOptions->whereIn('id', $request->product_option);
            $options = [
                'product_size' => [],
                'product_options' => [],
                'product_info' => [
                    'image' => $product->thumb_image,
                    'slug' => $product->slug
                ]
            ];
            if ($productSize != null) {
                $options['product_size'] =
                    [
                        'id' => $productSize?->id,
                        'name' => $productSize?->name,
                        'price' => $productSize?->price
                    ];
            }

            foreach ($productOptions as $option) {
                $options['product_options'][] = [
                    'id' => $option->id,
                    'name' => $option->name,
                    'price' => $option->price
                ];
            }
            Cart::add([
                'id' => $product->id,
                'name' => $product->name,
                'qty' => $request->quantity,
                'price' => $product->offer_price > 0 ? $product->offer_price : $product->price,
                'weight' => 0,
                'options' => $options,

            ]);

        return response(['status' => 'success', 'message' => 'Product added to Cart!'], 200);
        }catch (\Exception $error){
            return response(['status' => 'error', 'message' => 'Something Went Wrong!'], 500);

        }
    }

    public function getCartProducts()
    {
        return view('frontend.layouts.ajax-files.sidebar-cart-item')->render();
    }

    public function removeCartProduct($rowId){
        try {
            Cart::remove($rowId);
            return response(['message'=> 'Item Removed Successfully',
                'status'=> 'success',
                'cart_total'=> cartTotal(),
                'grand_cart_total' => grandCartTotal()
            ], 200);
        }
        catch (\Exception $error){
            return response(['message'=> 'Something Went Wrong!', 'status'=> 'error'], 500);

        }
    }

    public function updateCartQty(Request $request)
    {
        $cartItem = Cart::get($request->rowId);
        $product = Product::findOrFail($cartItem->id);
        if ($product->quantity < $request->qty){
            return response(['message' => 'Quantity out of stock', 'status'=> 'error', 'qty' => $cartItem->qty]);
        }
        try {
            $cart = Cart::update($request->rowId, $request->qty);
            return response(['status'=>'success',
                'product_total'=> productTotal($request->rowId),
                'qty'=> $cart->qty,
                'cart_total' => cartTotal(),
                'grand_cart_total' => grandCartTotal()
            ], 200);
        }catch (Exception $error){
            logger($error);
            return response(['message'=> 'Something Went Wrong! Refresh Page.', 'status'=> 'error'], 500);
        }
    }

    public function cartDestroy()
    {
        Cart::destroy();
        session()->forget('coupon');
        return response(['message'=> 'Cart Item Removed Successfully', 'status'=> 'success'], 200);
    }
}
