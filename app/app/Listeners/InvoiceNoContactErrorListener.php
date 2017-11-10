<?php

namespace App\Listeners;

use App\Events\InvoiceNoContactError;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class InvoiceNoContactErrorListener
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
     * @param  InvoiceNoContactError  $event
     * @return void
     */
    public function handle(InvoiceNoContactError $event)
    {
        //
    }
}
