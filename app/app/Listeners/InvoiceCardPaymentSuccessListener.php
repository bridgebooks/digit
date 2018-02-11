<?php

namespace App\Listeners;

use App\Events\InvoiceCardPaymentSuccess;
use App\Notifications\InvoicePaymentReceipt;
use App\Notifications\InvoicePaymentSuccess;
use App\Repositories\TransactionRepository;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class InvoiceCardPaymentSuccessListener
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
     * @param  InvoiceCardPaymentSuccess  $event
     * @return void
     */
    public function handle(InvoiceCardPaymentSuccess $event)
    {
        $contact = $event->invoice->contact;
        $org = $event->invoice->org;
        $advisers = $org->getUsersByRole('adviser');

        // send payment receipt
        // if ($contact->email) $contact->notify(new InvoicePaymentReceipt($event->invoice));

        if (count($advisers) > 0) {
            $advisers->each(function ($adviser) use ($event) {
                // notify org adviser
                $adviser->notify(new InvoicePaymentSuccess($event->invoice));
            });
        }

        // commit transaction
        $this->transactions->commitInvoicePayment($event->invoice, $event->payment);

    }
}
