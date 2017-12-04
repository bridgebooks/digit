<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Models\Account' => 'App\Policies\AccountPolicy',
        'App\Models\TaxRate' => 'App\Policies\TaxRatePolicy',
        'App\Models\Contact' => 'App\Policies\ContactPolicy',
        'App\Models\ContactPerson' => 'App\Policies\ContactPersonPolicy',
        'App\Models\ContactGroup' => 'App\Policies\ContactGroupPolicy',
        'App\Models\SalePurchaseItem' => 'App\Policies\SalePurchaseItemPolicy',
        'App\Models\OrgBankAccount' => 'App\Policies\OrgBankAccountPolicy',
        'App\Models\Invoice' => 'App\Policies\InvoicePolicy',
        'App\Models\OrgInvoiceSetting' => 'App\Policies\OrgInvoiceSettingPolicy',
        'App\Models\Employee' => 'App\Policies\EmployeePolicy',
        'App\Models\PayItem' => 'App\Policies\PayitemPolicy'
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
    }
}
