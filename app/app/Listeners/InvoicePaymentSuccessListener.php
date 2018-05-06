<?php

namespace App\Listeners;

use App\Events\InvoicePaymentSuccess;
use App\Notifications\InvoicePaymentReceipt;
use App\Notifications\InvoicePaymentSuccess as InvoicePaymentSuccessNotification;
use App\Repositories\TransactionRepository;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class InvoicePaymentSuccessListener
{
    protected $transactions;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(TransactionRepository $transactions)
    {
        $this->transactions = $transactions;
    }

    /**
     * Handle the event.
     *
     * @param  InvoicePaymentSuccess  $event
     * @return void
     */
    public function handle(InvoicePaymentSuccess $event)
    {
        $contact = $event->invoice->contact;
        $org = $event->invoice->org;
        $advisers = $org->getUsersByRole('adviser');

        // send payment receipt
        if ($contact->email && $event->invoice->type !== "acc_rec")
            $contact->notify(new InvoicePaymentReceipt($event->invoice));

        if (count($advisers) > 0) {
            $advisers->each(function ($adviser) use ($event) {
                // notify org adviser
                $adviser->notify(new InvoicePaymentSuccessNotification($event->invoice));
            });
        }

        // commit transaction
        $this->transactions->commitInvoicePayment($event->invoice, $event->payment);

    }
}
