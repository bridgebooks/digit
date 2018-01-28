<?php

namespace App\Listeners;

use Illuminate\Support\Facades\Notification;
use App\Jobs\GenerateInvoicePDF;
use App\Events\InvoiceSubmitted;
use App\Notifications\InvoiceSubmitted as InvoiceSubmittedNotification;
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
        // advisers
        $advisers = $event->invoice->org->getUsersByRole('adviser');

        // Generate PDF
        GenerateInvoicePDF::dispatch($event->invoice);

        if ($advisers) {
            // Notify advisers
            Notification::send($advisers, new InvoiceSubmittedNotification($event->invoice));
        }
    }
}
