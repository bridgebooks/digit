<?php

namespace App\Providers;

use App\Models\User;
use App\Models\Invoice;
use Illuminate\Support\ServiceProvider;
use App\Providers\RepositoryServiceProvider;

class ModelServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Model Observers
        User::observe(\App\Models\Observers\UserObserver::class);
        Invoice::observe(\App\Models\Observers\InvoiceObserver::class);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
    }
}
