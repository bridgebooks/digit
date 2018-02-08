<?php

namespace App\Listeners;

use App\Events\InvoiceAuthorized;
use App\Events\CommitInvoice;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Notifications\InvoiceAuthorized as InvoiceAuthorizedNotification;

class InvoiceAuthorizedListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Handle the event.
     *
     * @param  InvoiceAuthorized  $event
     * @return void
     */
    public function handle(InvoiceAuthorized $event)
    {
        // send InvoiceAuthorized email
        $user = $event->invoice->user;
        $user->notify(new InvoiceAuthorizedNotification($event->invoice));
        // commit transaction
        event(new CommitInvoice($event->invoice));
    }
}
