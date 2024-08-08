<?php

namespace App\Providers;

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;

class CustomeMailProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $emailSetting  = Cache::rememberForever('email_setting', function () {
           $key = [
               'mail_driver',
               'mail_host',
               'mail_port',
               'mail_user_name',
               'mail_password',
               'mail_encryption',
               'app_email',
               'customer_email',
           ];
           return Setting::whereIn('key', $key)->pluck('value', 'key')->toArray;
        });

        if ($emailSetting) {
            Config::set('mail.mailers.smtp.host', $emailSetting['mail_host']);
            Config::set('mail.mailers.smtp.port', $emailSetting['mail_port']);
            Config::set('mail.mailers.smtp.encryption', $emailSetting['mail_encryption']);
            Config::set('mail.mailers.smtp.username', $emailSetting['mail_user_name']);
            Config::set('mail.mailers.smtp.password', $emailSetting['mail_password']);
            Config::set('mail.from.address', $emailSetting['app_email']);
        }
    }
}
