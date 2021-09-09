<?php

namespace App\Providers;

use App\Channels\WebPushChannel;
use App\Http\Clients\OpenLiga;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(OpenLiga::class, function($app) {
            return new OpenLiga(2021);
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Notification::extend('push', function ($app) {
            return new WebPushChannel();
        });
        if(env('USE_BEHIND_PROXY', false))
            URL::forceRootUrl(env('PROXY_ROOT_URL', env('APP_URL', 'http://localhost/')));
    }
}
