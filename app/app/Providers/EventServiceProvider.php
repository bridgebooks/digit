<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\PrimaryUserCreated' => [
            'App\Listeners\PrimaryUserCreatedListener',
        ],
        'App\Events\OrgCreated' => [
            'App\Listeners\OrgCreatedListener'
        ],
        'App\Events\SendInvoice' => [
            'App\Listeners\SendInvoiceListener'
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
