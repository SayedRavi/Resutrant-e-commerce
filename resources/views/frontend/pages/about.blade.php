@extends('frontend.layouts.master')
@section('content')
    <!--=============================
        BREADCRUMB START
    ==============================-->
    <section class="fp__breadcrumb" style="background: url({{asset('frontend/images/counter_bg.jpg')}});">
        <div class="fp__breadcrumb_overlay">
            <div class="container">
                <div class="fp__breadcrumb_text">
                    <h1>about US</h1>
                    <ul>
                        <li><a href="{{route('home')}}">home</a></li>
                        <li><a href="javascript:;">about us</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <!--=============================
        BREADCRUMB END
    ==============================-->


    <!--=============================
        ABOUT PAGE START
    ==============================-->
    <section class="fp__about_us mt_120 xs_mt_90">
        <div class="container">
            <div class="row">
                <div class="col-xl-6 col-lg-5 wow fadeInUp" data-wow-duration="1s">
                    <div class="fp__about_us_img">
                        <img src="{{@$about->image}}" alt="about us" class="img-fluid w-100">
                    </div>
                </div>
                <div class="col-xl-6 col-lg-7 wow fadeInUp" data-wow-duration="1s">
                    <div class="fp__section_heading mb_40">
                        <h4>{{@$about->title}}</h4>
                        <h2>{{@$about->main_title}}</h2>
                        <span>
                            <img src="{{asset('frontend/images/heading_shapes.png')}}" alt="shapes" class="img-fluid w-100">
                        </span>
                    </div>
                    <div class="fp__about_us_text">
                        {!! $about->description !!}

                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="fp__why_choose mt_100 xs_mt_70">
        <div class="container">
            <div class="row wow fadeInUp" data-wow-duration="1s">
                <div class="col-md-8 col-lg-7 col-xl-6 m-auto text-center">
                    <div class="fp__section_heading mb_25">
                        <h4>{!! @$sectionTitle['why_choose_top_title'] !!}</h4>
                        <h2>{!! @$sectionTitle['why_choose_main_title'] !!}</h2>
                        <span>
                            <img src="{{asset('frontend/images/heading_shapes.png')}}" alt="shapes" class="img-fluid w-100">
                        </span>
                        <p>{!! @$sectionTitle['why_choose_sub_title'] !!}</p>
                    </div>
                </div>
            </div>
            <div class="row">
                @foreach($whyChooseUs as $item)
                    <div class="col-xl-4 col-md-6 col-lg-4">
                        <div class="fp__choose_single">
                            <div class="icon icon_1">
                                <i class="{{$item->icon}}"></i>
                            </div>
                            <div class="text">
                                <h3>{{$item->title}}</h3>
                                <p>{{$item->short_description}}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>


    <section class="fp__about_video mt_100 xs_mt_70">
        <div class="container wow fadeInUp" data-wow-duration="1s">
            <div class="fp__about_video_bg" style="background: url({{getYtThumbnail($about->video_link, 'high' )}});">
                <div class="fp__about_video_overlay">
                    <div class="row">
                        <div class="col-12">
                            <div class="fp__about_video_text">
                                <p>Watch Videos</p>
                                <a class="play_btn venobox" data-autoplay="true" data-vbtype="video"
                                   href="{{@$about->video_link}}">
                                    <i class=" fas fa-play"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="fp__team pt_95 xs_pt_65 pb_50">
        <div class="container">

            <div class="row wow fadeInUp" data-wow-duration="1s">
                <div class="col-md-8 col-lg-7 col-xl-6 m-auto text-center">
                    <div class="fp__section_heading mb_25">
                        <h4>{{@$sectionTitle['chefs_section_top_title']}}</h4>
                        <h2>{{@$sectionTitle['chefs_section_main_title']}}</h2>
                        <span>
                            <img src="{{asset('frontend/images/heading_shapes.png')}}" alt="shapes" class="img-fluid w-100">
                        </span>
                        <p>{{@$sectionTitle['chefs_section_sub_title']}}</p>
                    </div>
                </div>
            </div>

            <div class="row team_slider">
                @foreach($chefs as $chef)
                    <div class="col-xl-3 wow fadeInUp" data-wow-duration="1s">
                        <div class="fp__single_team">
                            <div class="fp__single_team_img">
                                <img src="{{asset($chef->image)}}" alt="team" class="img-fluid w-100">
                            </div>
                            <div class="fp__single_team_text">
                                <h4>{{$chef->name}}</h4>
                                <p>{{$chef->title}}</p>
                                <ul class="d-flex flex-wrap justify-content-center">
                                    @if($chef->fb)
                                        <li><a href="{{$chef->fb}}"><i class="fab fa-facebook-f"></i></a></li>
                                    @endif
                                    @if($chef->in)
                                        <li><a href="{{$chef->in}}"><i class="fab fa-linkedin-in"></i></a></li>
                                    @endif
                                    @if($chef->x)
                                        <li><a href="{{$chef->x}}"><i class="fab fa-twitter"></i></a></li>
                                    @endif
                                    @if($chef->web)
                                        <li><a href="{{$chef->web}}"><i class="fas fa-link"></i></a></li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>


    <section class="fp__counter" style="background: url({{asset('frontend/images/counter_bg2.jpg')}});">
        <div class="fp__counter_overlay pt_100 xs_pt_70 pb_100 xs_pb_70">
            <div class="container">
                <div class="row">
                    <div class="col-xl-3 col-sm-6 col-lg-3 wow fadeInUp" data-wow-duration="1s">
                        <div class="fp__single_counter">
                            <i class="{{$counter->counter_icon_one}}"></i>
                            <div class="text">
                                <h2 class="counter">{{$counter->counter_count_one}}</h2>
                                <p>{{$counter->counter_name_one}}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-sm-6 col-lg-3 wow fadeInUp" data-wow-duration="1s">
                        <div class="fp__single_counter">
                            <i class="{{$counter->counter_icon_two}}"></i>
                            <div class="text">
                                <h2 class="counter">{{$counter->counter_count_two}}</h2>
                                <p>{{$counter->counter_name_two}}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-sm-6 col-lg-3 wow fadeInUp" data-wow-duration="1s">
                        <div class="fp__single_counter">
                            <i class="{{$counter->counter_icon_three}}"></i>
                            <div class="text">
                                <h2 class="counter">{{$counter->counter_count_three}}</h2>
                                <p>{{$counter->counter_name_three}}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-sm-6 col-lg-3 wow fadeInUp" data-wow-duration="1s">
                        <div class="fp__single_counter">
                            <i class="{{$counter->counter_icon_four}}"></i>
                            <div class="text">
                                <h2 class="counter">{{$counter->counter_count_four}}</h2>
                                <p>{{$counter->counter_name_four}}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <section class="fp__testimonial pt_95 xs_pt_66 mb_150 xs_mb_120">
        <div class="container">
            <div class="row wow fadeInUp" data-wow-duration="1s">
                <div class="col-md-8 col-lg-7 col-xl-6 m-auto text-center">
                    <div class="fp__section_heading mb_40">
                        <h4>{{@$sectionTitle['testimonial_section_top_title']}}</h4>
                        <h2>{{@$sectionTitle['testimonial_section_main_title']}}</h2>
                        <span>
                            <img src="{{asset('frontend/images/heading_shapes.png')}}" alt="shapes" class="img-fluid w-100">
                        </span>
                        <p>{{@$sectionTitle['testimonial_section_sub_title']}}</p>
                    </div>
                </div>
            </div>

            <div class="row testi_slider">
                @foreach($testimonials as $testimonial)
                    <div class="col-xl-4 wow fadeInUp" data-wow-duration="1s">
                        <div class="fp__single_testimonial">
                            <div class="fp__testimonial_header d-flex flex-wrap align-items-center">
                                <div class="img">
                                    <img src="{{$testimonial->image}}" alt="clients" class="img-fluid w-100">
                                </div>
                                <div class="text">
                                    <h4>{{$testimonial->name}}</h4>
                                    <p>{{$testimonial->title}}</p>
                                </div>
                            </div>
                            <div class="fp__single_testimonial_body">
                                <p class="feedback">{{$testimonial->review}}</p>
                                <span class="rating">
                                @for($i=1; $i <= $testimonial->rating; $i++)
                                        <i class="fas fa-star"></i>
                                    @endfor

                            </span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!--=============================
        ABOUT PAGE END
    ==============================-->

@endsection
