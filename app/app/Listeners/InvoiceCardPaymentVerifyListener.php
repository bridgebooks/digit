<?php

namespace App\Listeners;

use App\Repositories\InvoicePaymentRepository;
use App\Events\InvoiceCardPaymentVerify;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class InvoiceCardPaymentVerifyListener
{
    protected $paymentRepository;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(InvoicePaymentRepository $paymentRepository)
    {
        $this->paymentRepository = $paymentRepository;
    }

    /**
     * Handle the event.
     *
     * @param  InvoiceCardPaymentVerify  $event
     * @return void
     */
    public function handle(InvoiceCardPaymentVerify $event)
    {
        // Update invoice payment
        $payment = $this->paymentRepository->skipPresenter()->findWhere(['invoice_id' => $event->invoice->id])->first();
        $payment->status = 'verified';
        $payment->save();

        // update invoice to paid
        $invoice->status = 'paid';
        $invoice->save();
    }
}
