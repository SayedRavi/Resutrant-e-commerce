<?php

namespace App\Services;


use Illuminate\Support\Facades\Cache;


class PaymentGatewaySetting
{
    function getSettings(){
        return Cache::rememberForever('gatewaySettings', function(){
            return \App\Models\PaymentGatewaySetting::pluck('value','key')->toArray();
        });
    }
    function setGlobalSettings(){
        $settings = $this->getSettings();
        config()->set('gatewaySettings', $settings);
    }
    function clearCachedSettings(){
        Cache::forget('gatewaySettings');
    }
}
