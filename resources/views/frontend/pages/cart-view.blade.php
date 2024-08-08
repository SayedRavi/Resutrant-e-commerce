@extends('frontend.layouts.master')
@section('content')
    <!--=============================
        BREADCRUMB START
    ==============================-->
    <section class="fp__breadcrumb" style="background: url(frontend/images/counter_bg.jpg);">
        <div class="fp__breadcrumb_overlay">
            <div class="container">
                <div class="fp__breadcrumb_text">
                    <h1>cart view</h1>
                    <ul>
                        <li><a href="index.html">home</a></li>
                        <li><a href="#">cart view</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <!--=============================
        BREADCRUMB END
    ==============================-->


    <!--============================
        CART VIEW START
    ==============================-->
    <section class="fp__cart_view mt_125 xs_mt_95 mb_100 xs_mb_70">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 wow fadeInUp" data-wow-duration="1s">
                    <div class="fp__cart_list">
                        <div class="table-responsive">
                            <table>
                                <tbody>
                                <tr>
                                    <th class="fp__pro_img">
                                        Image
                                    </th>

                                    <th class="fp__pro_name">
                                        details
                                    </th>

                                    <th class="fp__pro_status">
                                        price
                                    </th>

                                    <th class="fp__pro_select">
                                        quantity
                                    </th>

                                    <th class="fp__pro_tk">
                                        total
                                    </th>

                                    <th class="fp__pro_icon">
                                        <a class="clear_all" href="{{route('cart.destroy')}}">clear all</a>
                                    </th>
                                </tr>
                                @foreach(\Gloudemans\Shoppingcart\Facades\Cart::content() as $product)
                                    <tr>
                                        <td class="fp__pro_img"><img src="{{asset($product->options->product_info['image'])}}" alt="product"
                                                                     class="img-fluid w-100">
                                        </td>

                                        <td class="fp__pro_name">
                                            <a href="{{route('show.product', $product->options->product_info['slug'])}}">{{$product->name}}</a>
                                            <span>{{@$product->options->product_size['name']}} {{@$product->options->product_size['price'] ? '('.currencyPosition(@$product->options->product_size['price']).')' : ''}}</span>
                                            @foreach($product->options->product_options as $option)
                                            <p>{{@$option['name']}} ({{currencyPosition($option['price'])}})</p>
                                            @endforeach

                                        </td>

                                        <td class="fp__pro_status">
                                            <h6>{{currencyPosition($product->price)}}</h6>
                                        </td>

                                        <td class="fp__pro_select">
                                            <div class="quentity_btn">
                                                <button class="btn btn-danger decrement"><i class="fal fa-minus"></i></button>
                                                <input type="text" placeholder="1" data-id="{{$product->rowId}}" class="quantity" id="quantity" name="quantity" value="{{$product->qty}}">
                                                <button class="btn btn-success increment"><i class="fal fa-plus"></i></button>
                                            </div>
                                        </td>

                                        <td class="fp__pro_tk">
                                            <h6 class="product-total">{{currencyPosition(productTotal($product->rowId))}}</h6>
                                        </td>

                                        <td class="fp__pro_icon">
                                            <a href="#" class="removeProduct" data-id="{{$product->rowId}}"><i class="far fa-times"></i></a>
                                        </td>
                                    </tr>

                                @endforeach
                                @if(\Gloudemans\Shoppingcart\Facades\Cart::content()->count() < 1)
                                    <tr>
                                        <td colspan="6" class="text-center fp-pro-name" style="width: 100%; display: inline;">Cart is Empty!</td>

                                    </tr>
                                @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 wow fadeInUp" data-wow-duration="1s">
                    <div class="fp__cart_list_footer_button">
                        <h6>total cart</h6>
                        <p>subtotal: <span id="sub-total">{{currencyPosition(cartTotal())}}</span></p>
                        <p>delivery: <span>$00.00</span></p>
                        <p>discount: <span id="discount">
                                @if(isset(session()->get('coupon')['discount']))
                                    {{config('settings.site_currency_icon')}}{{session()->get('coupon')['discount']}}
                                @else
                                    {{config('settings.site_currency_icon')}}0
                                @endif

                            </span></p>
                        <p class="total"><span>total:</span> <span id="final-total">
                                @if(isset(session()->get('coupon')['discount']))
                                    {{config('settings.site_currency_icon')}} {{cartTotal() - session()->get('coupon')['discount']}}
                                @else
                                    {{config('settings.site_currency_icon')}}{{cartTotal()}}
                                @endif
                            </span></p>
                        <form id="coupon-apply">
                            <input type="text" name="code" id="coupon-code" placeholder="Coupon Code">
                            <button type="submit">apply</button>
                        </form>
                        <div class="coupon-card">
                            @if(session()->has('coupon'))
                                <div class="card mt-2">
                                    <div class="m-3">
                                        <span><b>Applied Coupon: {{session()->get('coupon')['code']}}</b></span>
                                        <span>
                                    <button id="destroy_coupon"><i class="far fa-times"></i></button>
                                </span>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <a class="common_btn" href="{{route('checkout.index')}}">checkout</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--============================
        CART VIEW END
    ==============================-->
@endsection

@push('scripts')
    <script>
        $(document).ready(function (){
            let cartTotal = "{{cartTotal()}}";
            //============================== Clicking Increment Button ===================================//

            $('.increment').on('click', function (){
               let inputField = $(this).siblings(".quantity");
               let currentValue = parseInt(inputField.val());
               let rowId = inputField.data('id');
                inputField.val(currentValue + 1);

               cartQtyUpdate(rowId, inputField.val(), function (response){
                  if(response.status === 'success'){
                      inputField.val(response.qty);
                      let productTotal = response.product_total;
                      inputField.closest('tr').find('.product-total')
                          .text("{{currencyPosition(':productTotal')}}".
                          replace(':productTotal', productTotal));
                      cartTotal = response.cart_total;
                      $('#sub-total').text("{{currencyPosition(':sub_total')}}".replace(":sub_total", cartTotal));
                      $('#final-total').text('{{config("settings.site_currency_icon")}}'+response.grand_cart_total)
                  }else if(response.status === 'error'){
                      inputField.val(response.qty);
                      toastr.error(response.message)
                  }
               });
            });
            //============================== Clicking Decrement Button ===================================//
            $('.decrement').on('click', function (){
                let inputField = $(this).siblings(".quantity");
                let currentValue = parseInt(inputField.val());
                let rowId = inputField.data('id');
                if(currentValue > 1){
                    inputField.val(currentValue - 1);
                    cartQtyUpdate(rowId, inputField.val(), function (response){
                        if(response.status === 'success'){
                            inputField.val(response.qty);
                            let productTotal = response.product_total;
                            inputField.closest('tr').find('.product-total')
                                .text("{{currencyPosition(':productTotal')}}".
                                replace(':productTotal', productTotal));
                            cartTotal = response.cart_total;
                            $('#sub-total').text("{{currencyPosition(':sub_total')}}".replace(":sub_total", cartTotal));
                            $('#final-total').text('{{config("settings.site_currency_icon")}}'+response.grand_cart_total)
                        }else if(response.status === 'error'){
                            inputField.val(response.qty);
                            toastr.error(response.message)
                        }
                    });
                }
            });

            //===================================== Updating Cart in view cart View with Ajax Request ===================//
            function cartQtyUpdate(rowId, qty, callback){
                $.ajax({
                    method: 'POST',
                    'url': '{{route('update-cart-qty')}}',
                    data: {
                      'rowId': rowId,
                        'qty': qty
                    },
                    beforeSend: function (){
                        showLoader()
                    },
                    success: function (response){
                        if (callback && typeof callback === 'function'){
                            callback(response);
                        }
                    },
                    error: function (xhr, status, error) {
                        let errorMessage = xhr.responseJSON.message;
                        hideLoader()
                        toastr.error(errorMessage);
                    },
                    complete: function () {
                        hideLoader()
                    }
                })
            }

            // ========= Removing Product From Cart firing function=====================//
            $('.removeProduct').on('click', function (e){
                e.preventDefault();
                let rowId = $(this).data('id');
                removeCartProduct(rowId);
                $(this).closest('tr').remove();
            })
            // ========= Removing Product From Cart ajax request=====================//

            function removeCartProduct(rowId){
                $.ajax({
                    method: 'GET',
                    url: '{{route('remove-cart-product', ":rowId")}}'. replace(":rowId", rowId),
                    beforeSend: function (){
                        showLoader()
                    },
                    success: function (response){
                        updateSidebarCart();
                       cartTotal = response.cart_total;
                        $('#sub-total').text("{{currencyPosition(':sub_total')}}".replace(":sub_total", cartTotal));
                        $('#final-total').text('{{config("settings.site_currency_icon")}}'+response.grand_cart_total)
                    },
                    error: function (xhr, status, error){
                        let errorMessage  = xhr.responseJSON.message;
                        toastr.error(errorMessage);
                    },
                    complete: function (){
                        hideLoader()
                    }
                })
            }

            //========================= Submitting Coupon =====================//
            $('#coupon-apply').on('submit', function (e){
                e.preventDefault();
                let code = $('#coupon-code').val();
                let subTotal = cartTotal;
                couponApply(code, subTotal);
            })
            //========================= Submitting Coupon ajax Request =====================//

            function couponApply(code, subTotal){
                $.ajax({
                    method: 'POST',
                    url: '{{route('apply-coupon')}}',
                    data: {
                      'code': code,
                      'subTotal': subTotal
                    },
                    beforeSend: function (){
                        showLoader()
                    },
                    success: function (response){
                        $('#coupon-code').val("");
                        $('#discount').text("{{config('settings.site_currency_icon')}}"+response.discount)
                        $('#final-total').text("{{config('settings.site_currency_icon')}}"+response.finalTotal)
                        let couponCartHtml = `<div class="card mt-2">
                                <div class="m-3">
                                    <span><b>Applied Coupon:${response.coupon_code}</b></span>
                                    <span>
                                    <button id="destroy_coupon"><i class="far fa-times"></i></button>
                                </span>
                                </div>
                            </div>`;
                        $('.coupon-card').html(couponCartHtml);
                        toastr.success(response.message);
                    },
                    error: function (xhr, status, error){
                        let errorMessage = xhr.responseJSON.message;
                        toastr.error(errorMessage);

                    },
                    complete: function (){
                        hideLoader()
                    }
                })
            }

        });

        $(document).on('click', '#destroy_coupon',function (){
            destroyCoupon();
        });
        function destroyCoupon(){
            $.ajax({
                method: 'GET',
                url: '{{route('destroy-coupon')}}',
                beforeSend: function () {
                    showLoader()
                },
                success: function (response) {
                    $('#discount').text("{{config('settings.site_currency_icon')}}"+0)
                    $('#final-total').text('{{config("settings.site_currency_icon")}}'+response.grand_cart_total)
                    $('.coupon-card').html("");

                    toastr.success(response.message);
                },
                error: function (xhr, status, error) {
                    let errorMessage = xhr.responseJSON.message;
                    hideLoader()
                    toastr.error(errorMessage)
                },
                complete: function () {
                    hideLoader()
                }
            })
        }
    </script>
@endpush
