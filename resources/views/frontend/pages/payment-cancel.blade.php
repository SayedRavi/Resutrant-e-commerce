@extends('frontend.layouts.master')
@section('content')

    <!--=============================
        BREADCRUMB START
    ==============================-->
    <section class="fp__breadcrumb" style="background: url({{asset('frontend/images/counter_bg.jpg')}});">
        <div class="fp__breadcrumb_overlay">
            <div class="container">
                <div class="fp__breadcrumb_text">
                    <h1>Order</h1>
                    <ul>
                        {{--                        <li><a href="{{route('home')}}">home</a></li>--}}
                        {{--                        <li><a href="javascript">payment</a></li>--}}
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <!--=============================
        BREADCRUMB END
    ==============================-->


    <!--============================
        PAYMENT PAGE START
    ==============================-->
    <section class="fp__payment_page mt_100 xs_mt_70 mb_100 xs_mb_70">
        <div class="container">
            <div class="row">
                <div class="text-center">
                    <div class="mb-4">
                        <i class="fas fa-times" style="font-size: 100px; background: red; padding: 10px 25px 10px 25px; border-radius: 50%; color: whitesmoke;"></i>
                    </div>
                    <h4>Transaction Failed!</h4>
                    <p><b class="mx-5">{{session()->has('errors') ?? session('errors')->first('error')}}</b></p>
                    <a href="{{route('dashboard')}}" class="common_btn mt-2">Go To Dashboard</a>
                </div>
            </div>
        </div>
    </section>
@endsection


