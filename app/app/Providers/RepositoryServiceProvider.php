<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
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
        $this->app->bind(\App\Repositories\UserRepository::class, \App\Repositories\UserRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\RoleRepository::class, \App\Repositories\RoleRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\OrgRepository::class, \App\Repositories\OrgRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\IndustryRepository::class, \App\Repositories\IndustryRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\ContactRepository::class, \App\Repositories\ContactRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\BankRepository::class, \App\Repositories\BankRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\ContactGroupRepository::class, \App\Repositories\ContactGroupRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\ContactPersonRepository::class, \App\Repositories\ContactPersonRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\OrgBankAccountRepository::class, \App\Repositories\OrgBankAccountRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\SalePurchaseItemRepository::class, \App\Repositories\SalePurchaseItemRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\AccountRepository::class, \App\Repositories\AccountRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\AccountTypeRepository::class, \App\Repositories\AccountTypeRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\TaxRateRepository::class, \App\Repositories\TaxRateRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\TaxRateComponentRepository::class, \App\Repositories\TaxRateComponentRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\InvoiceRepository::class, \App\Repositories\InvoiceRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\InvoiceLineItemRepository::class, \App\Repositories\InvoiceLineItemRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\OrgInvoiceSettingRepository::class, \App\Repositories\OrgInvoiceSettingRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\OrgRoleRepository::class, \App\Repositories\OrgRoleRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\InvoicePaymentRepository::class, \App\Repositories\InvoicePaymentRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\InvoicePaymentRepository::class, \App\Repositories\InvoicePaymentRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\EmployeeRepository::class, \App\Repositories\EmployeeRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\PayrunRepository::class, \App\Repositories\PayrunRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\PayItemRepository::class, \App\Repositories\PayItemRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\PayslipItemRepository::class, \App\Repositories\PayslipItemRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\PayslipRepository::class, \App\Repositories\PayslipRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\TransactionRepository::class, \App\Repositories\TransactionRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\OrgPayrunSettingRepository::class, \App\Repositories\OrgPayrunSettingRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\SubscriptionRepository::class, \App\Repositories\SubscriptionRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\PlanRepository::class, \App\Repositories\PlanRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\SubscriptionUsageRepository::class, \App\Repositories\SubscriptionUsageRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\OrgAccountSettingRepository::class, \App\Repositories\OrgAccountSettingRepositoryEloquent::class);
        //:end-bindings:
    }
}
