<?php

namespace App\Providers;

use App\Models\User;
use App\Models\Invoice;
use App\Models\Payslip;
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
        Payslip::observe(\App\Models\Observers\PayslipObserver::class);
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
