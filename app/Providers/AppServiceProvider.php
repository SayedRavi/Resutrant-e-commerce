<?php

namespace App\Providers;

use App\Events\OrderPaymentUpdateEvent;
use App\Events\OrderPlacedNotificationEvent;
use App\Events\RTOrderPlacedNotificationEvent;
use App\Listeners\OrderPaymentUpdateListener;
use App\Listeners\OrderPlacedNotificationListener;
use App\Listeners\RTOrderPlacedNotificationListener;
use App\Models\Setting;
use Config;
use Illuminate\Support\ServiceProvider;
use Log;
use Nette\Schema\Schema;
use Nette\Utils\Paginator;
use Symfony\Contracts\EventDispatcher\Event;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        \Illuminate\Support\Facades\Schema::defaultStringLength(191);

        \Illuminate\Support\Facades\Event::listen(
            OrderPaymentUpdateEvent::class,
            OrderPaymentUpdateListener::class,
        );
        \Illuminate\Support\Facades\Event::listen(
            OrderPlacedNotificationEvent::class,
            OrderPlacedNotificationListener::class

        );
        \Illuminate\Support\Facades\Event::listen(
            RTOrderPlacedNotificationEvent::class,
            RTOrderPlacedNotificationListener::class
        );


        //-----------Gets and sets the Pusher Credentials-------------------//
        $keys = ['pusher_key', 'pusher_secret', 'pusher_app_id', 'pusher_cluster'];
        $pushConfig = Setting::whereIn('key', $keys)->pluck('value', 'key');
        if ($pushConfig->isNotEmpty()) {
            Config::set('broadcasting.connections.pusher.key', $pushConfig['pusher_key']);
            Config::set('broadcasting.connections.pusher.secret', $pushConfig['pusher_secret']);
            Config::set('broadcasting.connections.pusher.app_id', $pushConfig['pusher_app_id']);
            Config::set('broadcasting.connections.pusher.options.cluster', $pushConfig['pusher_cluster']);
        }

        \Illuminate\Pagination\Paginator::useBootstrap();

    }
}
