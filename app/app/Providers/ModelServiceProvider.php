<?php

namespace App\Providers;

use App\Models\OrgPayrunSetting;
use App\Models\PayslipItem;
use App\Models\User;
use App\Models\Invoice;
use App\Models\Payrun;
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
        Payrun::observe(\App\Models\Observers\PayrunObserver::class);
        Payslip::observe(\App\Models\Observers\PayslipObserver::class);
        PayslipItem::observe(\App\Models\Observers\PayslipItemObserver::class);
        OrgPayrunSetting::observe(\App\Models\Observers\OrgPayrunSettingObserver::class);
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
