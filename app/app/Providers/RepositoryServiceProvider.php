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
        //:end-bindings:
    }
}
