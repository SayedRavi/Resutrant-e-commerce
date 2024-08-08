<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @yield('og_meta_tag_section')

    <title>FoodPark || Restaurant</title>
    <link rel="icon" type="image/png" href="{{asset('frontend/images/favicon.png')}}">
    <link rel="stylesheet" href="{{asset('frontend/css/all.min.css')}}">
    <link rel="stylesheet" href="{{asset('frontend/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('frontend/css/spacing.css')}}">
    <link rel="stylesheet" href="{{asset('frontend/css/slick.css')}}">
    <link rel="stylesheet" href="{{asset('frontend/css/nice-select.css')}}">
    <link rel="stylesheet" href="{{asset('frontend/css/venobox.min.css')}}">
    <link rel="stylesheet" href="{{asset('frontend/css/animate.css')}}">
    <link rel="stylesheet" href="{{asset('frontend/css/jquery.exzoom.css')}}">

    <link rel="stylesheet" href="{{asset('frontend/css/style.css')}}">
    <link rel="stylesheet" href="{{asset('frontend/css/responsive.css')}}">
    <link rel="stylesheet" href="{{asset('frontend/css/toastr.min.css')}}">
    <link rel="stylesheet" href="{{asset('frontend/css/custom.css')}}">
    <!-- <link rel="stylesheet" href="css/rtl.css"> -->
    <!--jquery library js-->
    <script src="{{asset('frontend/js/jquery-3.6.0.min.js')}}"></script>
    <script>
        var pusherKey = '{{config('settings.pusher_key')}}';
        var pusherCluster = '{{config('settings.pusher_cluster')}}';
        var loggedUserId = "{{auth()->user()->id ?? ''}}";
    </script>
    @vite(['resources/js/app.js', 'resources/js/frontend.js'])
</head>

<body>
<div class="overlay-container d-none" >
    <div class="overlay">
        <span class="loader"></span>
    </div>
</div>
<div class="fp__cart_popup">
    <div class="modal fade" id="cartModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body load_product_modal">

                </div>
            </div>
        </div>
    </div>
</div>

<!--=============================
    TOPBAR START
==============================-->
<section class="fp__topbar">
    <div class="container">
        <div class="row">
            <div class="col-xl-6 col-md-8">
                <ul class="fp__topbar_info d-flex flex-wrap">
                    <li><a href="mailto:example@gmail.com"><i class="fas fa-envelope"></i> Unifood@gmail.com</a>
                    </li>
                    <li><a href="callto:123456789"><i class="fas fa-phone-alt"></i> +96487452145214</a></li>
                </ul>
            </div>
            <div class="col-xl-6 col-md-4 d-none d-md-block">
                <ul class="topbar_icon d-flex flex-wrap">
                    <li><a href="#"><i class="fab fa-facebook-f"></i></a> </li>
                    <li><a href="#"><i class="fab fa-twitter"></i></a> </li>
                    <li><a href="#"><i class="fab fa-linkedin-in"></i></a> </li>
                    <li><a href="#"><i class="fab fa-behance"></i></a> </li>
                </ul>
            </div>
        </div>
    </div>
</section>
<!--=============================
    TOPBAR END
==============================-->


<!--=============================
    MENU START
==============================-->
    @include('frontend.layouts.menu')
<!--=============================
    MENU END
==============================-->


@yield('content')


<!--=============================
    FOOTER START
==============================-->
    @include('frontend.layouts.footer')
<!--=============================
    FOOTER END
==============================-->


<!--=============================
    SCROLL BUTTON START
==============================-->
<div class="fp__scroll_btn">
    go to top
</div>
<!--=============================
    SCROLL BUTTON END
==============================-->



<!--bootstrap js-->
<script src="{{asset('frontend/js/bootstrap.bundle.min.js')}}"></script>
<!--font-awesome js-->
<script src="{{asset('frontend/js/Font-Awesome.js')}}"></script>
<!-- slick slider -->
<script src="{{asset('frontend/js/slick.min.js')}}"></script>
<!-- isotop js -->
<script src="{{asset('frontend/js/isotope.pkgd.min.js')}}"></script>
<!-- simplyCountdownjs -->
<script src="{{asset('frontend/js/simplyCountdown.js')}}"></script>
<!-- counter up js -->
<script src="{{asset('frontend/js/jquery.waypoints.min.js')}}"></script>
<script src="{{asset('frontend/js/jquery.countup.min.js')}}"></script>
<!-- nice select js -->
<script src="{{asset('frontend/js/jquery.nice-select.min.js')}}"></script>
<!-- venobox js -->
<script src="{{asset('frontend/js/venobox.min.js')}}"></script>
<!-- sticky sidebar js -->
<script src="{{asset('frontend/js/sticky_sidebar.js')}}"></script>
<!-- wow js -->
<script src="{{asset('frontend/js/wow.min.js')}}"></script>
<!-- ex zoom js -->
<script src="{{asset('frontend/js/jquery.exzoom.js')}}"></script>

<!--main/custom js-->
<script src="{{asset('frontend/js/main.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script src="{{asset('frontend/js/toastr.min.js')}}"></script>
<script>
    toastr.options.progressBar = true;
    @if($errors->any)
        @foreach($errors->all() as $error)
            toastr.error('{{$error}}')
        @endforeach
    @endif
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    $('body').on('click', '.delete-item',function (event){
        event.preventDefault()
        let  url = $(this).attr('href');
        console.log(url);
        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!"
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    method: 'DELETE',
                    url: url,
                    data: {'_token': $('input[name="_token"]').val()},
                    success: function (response){
                        if (response.status === 'success'){
                            Swal.fire({
                                title: response.status,
                                text: response.message,
                                icon: "success"
                            });
                            if ($('.dataTable')){
                                $('table').DataTable().draw();
                            }
                            else if ($('.normal_table'|| '.table')){
                                window.location.reload();
                            }

                        }
                        else if (response.status === 'error'){
                            Swal.fire({
                                title: response.status,
                                text: response.message,
                                icon: "success"
                            });
                        }
                    },
                    error: function (error){
                        console.log(error)
                    }
                })

            }
        });
    })
</script>
@include('frontend.layouts.global-scripts');
@stack('scripts')

</body>

</html>
