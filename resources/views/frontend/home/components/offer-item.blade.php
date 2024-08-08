<section class="fp__offer_item mt_100 xs_mt_70 pt_95 xs_pt_65 pb_150 xs_pb_120">
    <div class="container">
        <div class="row wow fadeInUp" data-wow-duration="1s">
            <div class="col-md-8 col-lg-7 col-xl-6 m-auto text-center">
                <div class="fp__section_heading mb_50">
                    <h4>{{@$sectionTitle['daily_offer_top_title']}}</h4>
                    <h2>{{@$sectionTitle['daily_offer_main_title']}}</h2>
                    <span>
                            <img src="{{asset('frontend/images/heading_shapes.png')}}" alt="shapes" class="img-fluid w-100">
                        </span>
                    <p>{{@$sectionTitle['daily_offer_sub_title']}}</p>
                </div>
            </div>
        </div>

        <div class="row offer_item_slider wow fadeInUp" data-wow-duration="1s">
            @foreach($dailyOffers as $dailyOffer)
                <div class="col-xl-4">
                    <div class="fp__offer_item_single">
                        <div class="img">
                            <img src="{{asset($dailyOffer->product->thumb_image)}}" alt="offer" class="img-fluid w-100">
                        </div>
                        <div class="text">
                        @if($dailyOffer->product->offer_price > 0)
                                <span>{{discountInPercent($dailyOffer->product->price, $dailyOffer->product->offer_price)}}%</span>
                        @endif
                            <a class="title" href="{{route('show.product', $dailyOffer->product->slug)}}">{{$dailyOffer->product->name}}</a>
                            <p>{{$dailyOffer->product->short_description}}</p>
                            <ul class="d-flex flex-wrap">
                                <li><a href="javascript: void(0);" onclick="loadProductCart('{{$dailyOffer->product->id}}')"><i class="fas fa-shopping-basket"></i></a></li>
                                <li><a href="#"><i class="fal fa-heart"></i></a></li>
                                <li><a href="{{route('show.product', $dailyOffer->product->slug)}}"><i class="far fa-eye"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>

            @endforeach
        </div>
    </div>
</section>
