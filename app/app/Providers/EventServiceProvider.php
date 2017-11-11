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
        'App\Events\UserInvited' => [
            'App\Listeners\UserInvitedListener'
        ],
        'App\Events\InvoiceNoContactError' => [
            'App\Listeners\InvoiceNoContactErrorListener'
        ],
        'App\Events\SendInvoice' => [
            'App\Listeners\SendInvoiceListener'
        ],
        'App\Events\InvoiceSubmitted' => [
            'App\Listeners\InvoiceSubmittedListener'
        ],
        'App\Events\InvoiceCardPaymentInit' => [
            'App\Listeners\InvoiceCardPaymentInitListener'
        ],
        'App\Events\InvoiceCardPaymentVerify' => [
            'App\Listeners\InvoiceCardPaymentVerifyListener'
        ],
        'App\Events\InvoiceCardPaymentVerifyFail' => [
            'App\Listeners\InvoiceCardPaymentVerifyFailListener'
        ]
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
