<?php

use App\Http\Controllers\Admin\AboutController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminProfileController;
use App\Http\Controllers\Admin\AppDownloadSectionController;
use App\Http\Controllers\Admin\BannerSliderController;
use App\Http\Controllers\Admin\CategoryContoller;
use App\Http\Controllers\Admin\ChatController;
use App\Http\Controllers\Admin\ChefController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\DailyOfferController;
use App\Http\Controllers\Admin\DeliveryAreaController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\PaymentGatewaySettingController;
use App\Http\Controllers\Admin\PrivacyPolicyController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProductGalleryController;
use App\Http\Controllers\Admin\ProductSizeController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\TermsAndConditionsController;
use App\Http\Controllers\Admin\TestimonialController;
use App\Http\Controllers\Admin\WhyChooseUsController;
use App\Http\Controllers\BlogCategoryController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CounterController;
use App\Models\BannerSlider;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'admin','as'=>'admin.'], function (){
    Route::get('dashboard',[AdminDashboardController::class,'index'])->name('dashboard');
    Route::get('profile',[AdminProfileController::class,'index'])->name('profile');
    Route::put('profile',[AdminProfileController::class,'updateProfile'])->name('profile.update');
    Route::put('profile/password',[AdminProfileController::class,'updatePassword'])->name('password.update');


    //    Slider Routes
    Route::resource('/slider', SliderController::class);


    //    Why Choose Us section Routes
    Route::patch('why-choose-us', [WhyChooseUsController::class, 'updateTitle'])->name('whyChoose.updateTitle');
    Route::resource('why-choose-us', WhyChooseUsController::class);


    //    Category Routes
    Route::resource('category', CategoryContoller::class);


    //    Product Routes
    Route::resource('product', ProductController::class);


    //    Product Gallery Routes
    Route::get('product-gallery/{product}', [ProductGalleryController::class, 'index'])->name('product-gallery-show.index');
    Route::resource('product-gallery', ProductGalleryController::class);


    //    Product Size Routes
    Route::get('product-size/{product}', [ProductSizeController::class, 'index'])->name('product-size-show.index');
    Route::resource('product-sizes', ProductSizeController::class);


    //    Product Option Routes
    Route::resource('product-option', \App\Http\Controllers\Admin\ProductOptionController::class);


    //    Coupon Routes
    Route::resource('coupon', CouponController::class);

    //    Order Routes
    Route::get('order', [OrderController::class, 'index'])->name('order.index');
    Route::get('order/{id}', [OrderController::class, 'show'])->name('order.show');
    Route::delete('order/{id}', [OrderController::class, 'destroy'])->name('order.destroy');
    Route::get('pending-order', [OrderController::class, 'pendingOrderIndex'])->name('pending-order.index');
    Route::get('in-process-order', [OrderController::class, 'inProcessOrderIndex'])->name('in-process-order.index');
    Route::get('delivered-order', [OrderController::class, 'deliveredOrderIndex'])->name('delivered-order.index');
    Route::get('declined-order', [OrderController::class, 'declinedOrderIndex'])->name('declined-order.index');

    Route::get('order/status/{id}',[OrderController::class, 'getOrderStatus'])->name('get.order.status');
    Route::patch('order/status-update/{id}', [OrderController::class, 'orderStatusUpdate'])->name('order.status.update');


    // Clear Notifications From admin Dashboard
    Route::get('clear-notification', [AdminDashboardController::class, 'clearNotification'])->name('clear-notification');


    // Chat Section Routes
    Route::get('chat', [ChatController::class, 'index'])->name('chat.index');
    Route::get('chat/get-conversation/{senderId}', [ChatController::class, 'getConversation'])->name('chat.get-conversation');
    Route::post('chat/send-message', [ChatController::class, 'sendMessage'])->name('chat.send.message');


//    Daily Offer Section Routes
    Route::get('daily-offer/search-product', [DailyOfferController::class, 'searchProduct'])->name('daily-offer.search');
    Route::patch('daily-offers-title', [DailyOfferController::class, 'updateTitle'])->name('dailyOffer.updateTitle');
    Route::resource('daily-offer', DailyOfferController::class);

//    Banner Slider Section Routes

    Route::resource('banner-slider', BannerSliderController::class);

//    Chefs Section Routes
    Route::patch('chef-section-title', [ChefController::class, 'updateTitle'])->name('chefs.updateTitle');
    Route::resource('chef', ChefController::class);

//    App Download Section Routes
    Route::get('app-download', [AppDownloadSectionController::class, 'index'])->name('app-download.index');
    Route::post('app-download', [AppDownloadSectionController::class, 'store'])->name('app-download.store');

//    Testimonial Section Routes
    Route::patch('testimonial-section-title', [TestimonialController::class, 'updateTitle'])->name('testimonial.updateTitle');
    Route::resource('testimonial', TestimonialController::class);

//    Counter Section Routes
    Route::get('counter', [CounterController::class, 'index'])->name('counter.index');
    Route::patch('counter-update', [CounterController::class, 'update'])->name('counter.update');

//    Blog Section Routes
    Route::get('blog/comments', [BlogController::class, 'blogComment'])->name('blog.comments.index');
    Route::get('blog/comments/{id}', [BlogController::class, 'commentStatusUpdate'])->name('blog.comments.status.update');
    Route::delete('blog/comments/{id}', [BlogController::class, 'commentDestroy'])->name('blog.comments.destroy');
    Route::resource('blog', BlogController::class);
    Route::resource('blog-category', BlogCategoryController::class);

//    About section Routes
    Route::get('about', [AboutController::class, 'index'])->name('about.index');
    Route::patch('about', [AboutController::class, 'update'])->name('about.update');

    //    Privacy Policy section Routes
    Route::get('privacy-policy', [PrivacyPolicyController::class, 'index'])->name('privacy-policy.index');
    Route::patch('privacy-policy', [PrivacyPolicyController::class, 'update'])->name('privacy-policy.update');

    //    Terms and Conditions section Routes
    Route::get('terms-and-conditions', [TermsAndConditionsController::class, 'index'])->name('terms-and-conditions.index');
    Route::patch('terms-and-conditions', [TermsAndConditionsController::class, 'update'])->name('terms-and-conditions.update');

    //    Terms and Conditions section Routes
    Route::get('contact', [ContactController::class, 'index'])->name('contact.index');
    Route::patch('contact', [ContactController::class, 'update'])->name('contact.update');

    //    Setting Routes
    Route::get('setting',[SettingController::class, 'index'])->name('setting.index');
    Route::patch('general-setting',[SettingController::class, 'updateGeneralSetting'])->name('general-setting.update');
    Route::patch('pusher-setting',[SettingController::class, 'updatePusherSetting'])->name('pusher-setting.update');
    Route::patch('mail-setting',[SettingController::class, 'updateMailSetting'])->name('mail-setting.update');


    //    Payment Gateway Settings Routes
    Route::get('payment-gateway-setting', [PaymentGatewaySettingController::class, 'index'])->name('payment-gateway-setting');
    Route::Patch('paypal-setting-update', [PaymentGatewaySettingController::class, 'paypalSettingUpdate'])->name('paypal.setting.update');
    Route::Patch('stripe-setting-update', [PaymentGatewaySettingController::class, 'stripeSettingUpdate'])->name('stripe.setting.update');
//    Route::Patch('razorpay-setting-update', [\App\Http\Controllers\Admin\PaymentGatewaySettingController::class, 'razorpaySettingUpdate'])->name('razorpay.setting.update');


    //delivery Areas Routes
    Route::resource('delivery-areas', DeliveryAreaController::class);
});

