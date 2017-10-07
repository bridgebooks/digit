<?php

namespace App\Models\Observers;

use Log;
use App\Models\Invoice;

class InvoiceObserver
{
    /**
     * Listen to the Invoice created event.
     *
     * @param  Invoice  $user
     * @return void
     */
    public function created(Invoice $invoice)
    {
        
    }

    /**
     * Listen to the Invoice updated event.
     *
     * @param  Invoice  $user
     * @return void
     */
    public function updated(Invoice $invoice)
    {
        
    }
}