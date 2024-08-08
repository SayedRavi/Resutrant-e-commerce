<input type="hidden" value="{{cartTotal()}}" id="cart-total">
<input type="hidden" value="{{count(\Gloudemans\Shoppingcart\Facades\Cart::content())}}" id="cart-product-count">
@foreach(Cart::content() as $cartContent)
    <li>
        <div class="menu_cart_img">
            <img src="{{asset($cartContent->options->product_info['image'])}}" alt="menu" class="img-fluid w-100">
        </div>
        <div class="menu_cart_text">
            <a class="title" href="{{route('show.product', $cartContent->options->product_info['slug'])}}">{!! @$cartContent->name !!} </a>
            <p class="size">{{@$cartContent->options->product_size['name']}}
                {{@$cartContent->options->product_size['price'] ?
                '('.currencyPosition(@$cartContent->options->product_size['price']).')' : ''}}</p>
        @foreach($cartContent->options->product_options as $option)
                <span class="extra">{{@$option['name']}}({{currencyPosition(@$option['price'])}})</span>
            @endforeach
            <p class="price">{{currencyPosition($cartContent->price)}}</p>
        </div>
        <span class="del_icon" onclick="removeProductFromCart('{{$cartContent->rowId}}')"><i class="fal fa-times"></i></span>
    </li>
@endforeach
