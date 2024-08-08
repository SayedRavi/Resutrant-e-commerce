<?php

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\ChatController;
use App\Http\Controllers\Frontend\cartController;
use App\Http\Controllers\Frontend\ChatController as FrontendChatController;
use App\Http\Controllers\Frontend\ChechoutController;
use App\Http\Controllers\Frontend\CheckoutController;
use App\Http\Controllers\Frontend\DashboardController;
use App\Http\Controllers\Frontend\PaymentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\frontend\FrontendContoller;
use App\Models\Setting;
use Illuminate\Support\Facades\Route;

Route::group(['middleware'=>'guest'],function (){
    Route::get('admin/login',[\App\Http\Controllers\Admin\AdminAuthController::class, 'index'])->name('admin.login');
});

Route::get('/',[FrontendContoller::class, 'index'])->name('home');
Route::get('product/{slug}', [FrontendContoller::class, 'showProduct'])->name('show.product');
//Chefs Page Route
Route::get('chef', [FrontendContoller::class, 'chef'])->name('chef');
//Testimonials Page Route
Route::get('testimonial', [FrontendContoller::class, 'testimonial'])->name('testimonial.testimonials');



Route::group(['middleware'=>'auth','verified'], function (){
   Route::get('dashboard',[DashboardController::class, 'index'])->name('dashboard');
   Route::put('profile',[ProfileController::class,'updateProfile'])->name('userprofile.update');
   Route::put('profile/password',[ProfileController::class,'updatePassword'])->name('userprofile.password.update');
   Route::post('profile/avatar',[ProfileController::class,'updateAvatar'])->name('userprofile.avatar.update');
   Route::post('address',[DashboardController::class, 'storeAddress'])->name('store.address');
   Route::patch('address/{id}/update',[DashboardController::class, 'updateAddress'])->name('update.address');
   Route::delete('address/{id}/delete',[DashboardController::class, 'deleteAddress'])->name('delete.address');

        //   Chat Routes
    Route::get('chat/get-conversation/{senderId}', [ChatController::class, 'getConversation'])->name('chat.get-conversation');
    Route::post('chat/send-message', action: [FrontendChatController::class, 'sendMessage'])->name('chat.send.message');
});

//Route::middleware('auth')->group(function () {
//    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
//});

Route::get('admin/dashboard',[AdminDashboardController::class,'index'])->middleware('auth','role:admin')->name('admin.dashboard');

require __DIR__.'/auth.php';

Route::get('/load-product-modal/{productId}', [FrontendContoller::class, 'loadProductModal'])->name('load-product-modal');

// Cart Routes
Route::post('add-to-cart', [cartController::class, 'addToCart'])->name('add-to-cart');
Route::get('get-cart-products', [cartController::class, 'getCartProducts'])->name('get-cart-products');
Route::get('remove-cart-product/{rowId}',[cartController::class, 'removeCartProduct'])->name('remove-cart-product');

//Cart Page Routes
Route::get('cart', [cartController::class,'index'])->name('cart.index');
Route::post('update-cart-qty', [cartController::class,'updateCartQty'])->name('update-cart-qty');
Route::get('cart-destroy', [cartController::class,'cartDestroy'])->name('cart.destroy');

//Coupon Routes
Route::post('apply-coupon', [FrontendContoller::class, 'applyCoupon'])->name('apply-coupon');
Route::get('destroy-coupon', [FrontendContoller::class, 'destroyCoupon'])->name('destroy-coupon');

//    Blog Routes
Route::get('blogs', [FrontendContoller::class, 'blogs'])->name('blogs');
Route::get('blogs/{slug}', [FrontendContoller::class, 'blogDetails'])->name('blog.details');
Route::post('blogs/comment/{blog_id}', [FrontendContoller::class, 'blogCommentStore'])->name('blog.comment.store');


//About Section Routes
Route::get('about', [FrontendContoller::class, 'about'])->name('about');

//    Privacy Policy Routes
    Route::get('privacy-policy', [FrontendContoller::class, 'privacyPolicy'])->name('privacy-policy');

//    Terms and Conditions Routes
    Route::get('terms-and-conditions', [FrontendContoller::class, 'termsAndConditions'])->name('terms-and-conditions');

//    Contact Page Routes
    Route::get('contact', [FrontendContoller::class, 'contact'])->name('contact');

Route::group(['middleware'=>'auth'], function (){
   Route::get('checkout', [CheckoutController::class, 'index'])->name('checkout.index');
   Route::get('checkout/{id}/delivery-cal', [CheckoutController::class, 'deliveryCalculation'])->name('checkout.deliveryCal');
   Route::post('checkout-to-pay', [CheckoutController::class, 'checkoutRedirect'])->name('checkout.redirect');

//   Payment Routes
   Route::get('payment', [\App\Http\Controllers\Frontend\PaymentController::class, 'index'])->name('payment.index');
   Route::post('make-payment', [\App\Http\Controllers\Frontend\PaymentController::class, 'makePayment'])->name('make.payment');

//   Success and Cancel Routes
   Route::get('payment-success', [PaymentController::class, 'paymentSuccess'])->name('payment.success');
   Route::get('payment-cancel', [PaymentController::class, 'paymentCancel'])->name('payment.cancel');

//   Paypal Routes
   Route::get('paypal/payment', [PaymentController::class, 'paypalPayment'])->name('paypal.payment');
   Route::get('paypal/success', [PaymentController::class, 'paypalSuccess'])->name('paypal.success');
   Route::get('paypal/cancel', [PaymentController::class, 'paypalCancel'])->name('paypal.cancel');

//   Stripe Routes
    Route::get('stripe/payment', [PaymentController::class, 'stripePayment'])->name('stripe.payment');
    Route::get('stripe/success', [PaymentController::class, 'stripeSuccess'])->name('stripe.success');
    Route::get('stripe/cancel', [PaymentController::class, 'stripeCancel'])->name('stripe.cancel');


});

