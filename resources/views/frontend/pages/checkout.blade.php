@extends('frontend.layouts.master')
@section('content')
    <!--=============================
        BREADCRUMB START
    ==============================-->
    <section class="fp__breadcrumb" style="background: url({{asset('frontend/images/counter_bg.jpg')}});">
        <div class="fp__breadcrumb_overlay">
            <div class="container">
                <div class="fp__breadcrumb_text">
                    <h1>checkout</h1>
                    <ul>
                        <li><a href="index.html">home</a></li>
                        <li><a href="#">checkout</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <!--=============================
        BREADCRUMB END
    ==============================-->


    <!--============================
        CHECK OUT PAGE START
    ==============================-->
    <section class="fp__cart_view mt_125 xs_mt_95 mb_100 xs_mb_70">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-lg-7 wow fadeInUp" data-wow-duration="1s">
                    <div class="fp__checkout_form">
                        <div class="fp__check_form">
                            <h5>select address <a href="#" data-bs-toggle="modal" data-bs-target="#address_modal"><i
                                        class="far fa-plus"></i> add address</a></h5>

                            <div class="fp__address_modal">
                                <div class="modal fade" id="address_modal" data-bs-backdrop="static"
                                     data-bs-keyboard="false" tabindex="-1" aria-labelledby="address_modalLabel"
                                     aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="address_modalLabel">add new address
                                                </h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="fp_dashboard_new_address d-block">
                                                <form action="{{route('store.address')}}" method="post">
                                                    @csrf
                                                    <div class="row">
                                                        <div class="col-md-12 col-lg-12 col-xl-12">
                                                            <div class="fp__check_single_form">
                                                                <select name="delivery_area_id" class="nice_select">
                                                                    <option value="">select Area</option>
                                                                    @foreach($delivery_areas as $area)
                                                                        <option value="{{$area->id}}">{{$area->area_name}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-lg-12 col-xl-6">
                                                            <div class="fp__check_single_form">
                                                                <input type="text" placeholder="First Name" name="first_name">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-lg-12 col-xl-6">
                                                            <div class="fp__check_single_form">
                                                                <input type="text" placeholder="Last Name" name="last_name">
                                                            </div>
                                                        </div>

                                                        <div class="col-md-6 col-lg-12 col-xl-6">
                                                            <div class="fp__check_single_form">
                                                                <input type="text" placeholder="Phone *" name="phone">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-lg-12 col-xl-6">
                                                            <div class="fp__check_single_form">
                                                                <input type="email" placeholder="Email *" name="email">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12 col-lg-12 col-xl-12">
                                                            <div class="fp__check_single_form">
                                                                <textarea cols="3" rows="4" placeholder="Address" name="address"></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="col-12">
                                                            <div class="fp__check_single_form check_area">
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio"
                                                                           name="type" id="flexRadioDefault1" value="home">
                                                                    <label class="form-check-label"
                                                                           for="flexRadioDefault1">
                                                                        home
                                                                    </label>
                                                                </div>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio"
                                                                           name="type" id="flexRadioDefault2" value="office">
                                                                    <label class="form-check-label"
                                                                           for="flexRadioDefault2">
                                                                        office
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                            <div style="display: flex;">
                                                            <button style="width: 200px;" type="button"
                                                                    class="common_btn cancel_new_address mr-2">cancel
                                                            </button>
                                                            <button style="width: 200px;" type="submit" class="common_btn">save
                                                                address
                                                            </button>
                                                             </div>
                                                    </div>
                                                </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                @foreach($user_addresses as $address)
                                    <div class="col-md-6">
                                        <div class="fp__checkout_single_address">
                                            <div class="form-check">
                                                <input class="form-check-input v_address" required value="{{$address->id}}" type="radio" name="flexRadioDefault"
                                                       id="home">
                                                    @if($address->type === 'home')
                                                    <label class="form-check-label" for="home">
                                                        <span class="icon"><i class="fas fa-home"></i> {{$address->type}}</span>
                                                    </label>
                                                    @else
                                                        <label>
                                                        <span class="icon"><i class="far fa-car-building">{{$address->type}}</i></span>
                                                        </label>
                                                    @endif
                                                    <span class="address">{!! $address->address !!}, {{$address->deliveryArea?->area_name}}</span>
                                            </div>
                                        </div>
                                    </div>

                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 wow fadeInUp" data-wow-duration="1s">
                    <div id="sticky_sidebar" class="fp__cart_list_footer_button">
                        <h6>total cart</h6>
                        <p>subtotal: <span>{{currencyPosition(cartTotal())}}</span></p>
                        <p>delivery: <span id="delivery_fee">$0.0</span></p>

                        @if(session()->has('coupon'))
                            <p>discount: <span>{{currencyPosition(session()->get('coupon')['discount'])}}</span></p>
                        @else
                            <p>discount: <span>{{currencyPosition('0')}}</span></p>
                        @endif
                        <p class="total"><span>total:</span> <span id="grandTotal">{{currencyPosition(grandCartTotal())}}</span></p>
                        <a class="common_btn" href=" #" id="proceed_pmt_button">Proceed To Payment</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--============================
        CHECK OUT PAGE END
    ==============================-->
@endsection
@push('scripts')
    <script>
        $(document).ready(function (){
            $('.v_address').on('click', function (){
                let address_id  = $(this).val();
                let deliverFee = $('#delivery_fee');
                let grandTotal = $('#grandTotal');
                $.ajax({
                    method: 'GET',
                    url: '{{route('checkout.deliveryCal', ':id')}}'.replace(':id', address_id),
                    beforeSend: function (){
                        showLoader()
                    },
                    success: function (response){
                        deliverFee.text("{{currencyPosition(':deliveryFee')}}".replace(":deliveryFee", response.delivery_fee));
                        grandTotal.text("{{currencyPosition(':grandTotal')}}".replace(":grandTotal", response.grandTotal));
                    },
                    error: function (xhr, status, error){
                        let errorMessage = xhr.responseJSON.message;
                        toastr.error(errorMessage);
                    },
                    complete: function (){
                        hideLoader()
                    }
                })
            })

            $('#proceed_pmt_button').on('click',function (e){
                e.preventDefault();
                let addressId = $('.v_address:checked');
                let id = addressId.val();
                if(addressId.length === 0){
                    toastr.error('Please Select an Address');
                    return;
                }
            $.ajax({
                method: 'POST',
                url: '{{route('checkout.redirect')}}',
                data: {
                    id: id
                },
                beforeSend: function (){
                    showLoader()
                },
                success: function (response){
                    window.location.href = response.redirect_url;
                },
                error: function (xhr, status, error){
                    let errorMessage = xhr.responseJSON.message;
                    toastr.error(errorMessage);
                },
                complete: function (){
                    hideLoader()
                }
            })

            })
        })
    </script>
@endpush
