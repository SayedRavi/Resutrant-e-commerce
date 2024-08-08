<?php

if (!function_exists('generateUniqueSlug')) {
    function generateUniqueSlug($model, $name)
    {
        $modelClass = "App\\Models\\$model";
        if (!class_exists($modelClass)) {
            throw new \http\Exception\InvalidArgumentException("Model $model does not Exist.");
        }
        $slug = \Illuminate\Support\Str::slug($name);
        $count = 2;
        while ($modelClass::where('slug', $slug)->exists()) {
            $slug = \Illuminate\Support\Str::slug($name) . '-' . $count;
            $count++;
        }

        return $slug;
    }
}
    if (!function_exists('currencyPosition')){
        function currencyPosition($price){
            if (config('settings.site_currency_position') === 'left'){
                return config('settings.site_currency_icon') . $price;
            }
            else{
                return  $price . config('settings.site_currency_icon');

            }
        }
    }
    if (!function_exists('cartTotal')){
        function cartTotal(){
            $total = 0;
            foreach (\Gloudemans\Shoppingcart\Facades\Cart::content() as $item){
            $productPrice = $item->price;
            $sizePrice = $item->options?->product_size['price'] ?? 0;
            $optionPrice = 0;
            foreach ($item->options?->product_options as $option){
                $optionPrice += $option['price'];
            }
            $total += ($productPrice + $sizePrice) * $item->qty + $optionPrice;
            }
            return $total;
        }
    }
if (!function_exists('productTotal')) {
    function productTotal($rowId)
    {
        $total = 0;
        $product = \Gloudemans\Shoppingcart\Facades\Cart::get($rowId);

        $productPrice = $product->price;
        $sizePrice = $product->options?->product_size['price'] ?? 0;
        $optionPrice = 0;
        foreach ($product->options?->product_options as $option) {
            $optionPrice += $option['price'];
        }
        $total += ($productPrice + $sizePrice) * $product->qty + $optionPrice;
        return $total;
    }
}
if (!function_exists('grandCartTotal')) {
    function grandCartTotal($delivery_fee = 0)
    {
        $total = 0;
        $cartTotal = cartTotal();
        if (session()->has('coupon')){
            $discount = session()->get('coupon')['discount'];
            $total = ($cartTotal + $delivery_fee) - $discount;
            return $total;
        }else{
            $total = $cartTotal + $delivery_fee;
            return $total;
        }
    }
}
if (!function_exists('generateInvoiceId')) {
    function generateInvoiceId($delivery_fee = 0)
    {
        $randomNumber = rand(1, 9999);
        $currentDateTime = now();

        $invoiceId = $randomNumber.$currentDateTime->format('yd').$currentDateTime->format('s');

        return $invoiceId;
    }
}
if (!function_exists('discountInPercent')) {
    function discountInPercent($originalPrice, $discountPercent)
    {
        $result = round((($originalPrice - $discountPercent) / $originalPrice) * 100);
        return $result;
    }
}

if (!function_exists('truncate')) {
    function truncate($string, $lenght = 100)
    {
        return Str::limit($string, $lenght, '...');
    }
}

//if (!function_exists('getYtThumbnail')) {
//    function getYtThumbnail($link, $size = 'medium')
//    {
//        $videoId = explode('?v=', $link);
//        $videoId = $videoId[1];
//
//        $finalSize = match ($size){
//            'low' => 'sddefault',
//            'medium' => 'mddefault',
//            'high' => 'hqdefault',
//            'max' => 'maxresdefault'
//        };
//
//        return 'https://img.youtube.com/vi/' . $videoId . '/' . $finalSize . '.jpg';
//    }
//}

//Copied from chat-gpt ai
if (!function_exists('getYtThumbnail')) {
    function getYtThumbnail($link, $size = 'medium')
    {
        // Extract the video ID from different possible YouTube URL patterns
        if (preg_match('/(?:youtube\.com\/(?:[^\/\n\s]+\/\S+\/|(?:v|e(?:mbed)?)\/|\S*?[?&]v=)|youtu\.be\/)([a-zA-Z0-9_-]{11})/', $link, $matches)) {
            $videoId = $matches[1];
        } else {
            return 'Invalid YouTube URL';
        }

        // Determine the thumbnail size
        $finalSize = match ($size) {
            'low' => 'sddefault',
            'medium' => 'mqdefault', // Corrected to 'mqdefault' for medium size
            'high' => 'hqdefault',
            'max' => 'maxresdefault',
            default => 'mqdefault', // Default to medium if size is invalid
        };

        // Return the YouTube thumbnail URL
        return 'https://img.youtube.com/vi/' . $videoId . '/' . $finalSize . '.jpg';
    }
}
