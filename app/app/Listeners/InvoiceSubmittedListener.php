<?php

namespace App\Listeners;

use App\Jobs\GenerateInvoicePDF;
use App\Events\InvoiceSubmitted;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class InvoiceSubmittedListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  InvoiceSubmitted  $event
     * @return void
     */
    public function handle(InvoiceSubmitted $event)
    {
        GenerateInvoicePDF::dispatch($event->invoice);
    }
}
