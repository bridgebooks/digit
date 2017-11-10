<?php

namespace App\Providers;

use Cache;
use Carbon\Carbon;
use Emmanix2002\Moneywave\Moneywave;
use Illuminate\Support\ServiceProvider;

class MoneywaveProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        // config paramaters
        $apiKey = config('mw.api_key');
        $secretKey = config('mw.secret_key');
        $env = config('mw.env');

        $this->app->bind('Emmanix2002\Moneywave\Moneywave', function ($app) use ($apiKey, $secretKey, $env) {
            if (Cache::has('mw.access_token')) {
                $accessToken = Cache::get('mw.access_token');
                return new Moneywave($accessToken, $apiKey, $secretKey, $env);
            }

            $mw = new Moneywave(null, $apiKey, $secretKey, $env);
            $mw->verifyMerchant();
            $accessToken = $mw->getAccessToken();

            Cache::put('mw.access_token', $accessToken, Carbon::now()->addHours(2));

            return $mw;
        });
    }
}
