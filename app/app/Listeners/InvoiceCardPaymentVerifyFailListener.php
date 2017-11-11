<?php

namespace App\Listeners;

use App\Events\InvoiceCardPaymentVerifyFail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\Repositories\InvoicePaymentRepository;

class InvoiceCardPaymentVerifyFailListener implements ShouldQueue
{
    use InteractsWithQueue;
    
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
     * @param  InvoiceCardPaymentVerifyFail  $event
     * @return void
     */
    public function handle(InvoiceCardPaymentVerifyFail $event)
    {
        $this->paymentRepository->skipPresenter();

        $payment = $this->paymentRepository->findWhere([
            'invoice_id' => $event->invoice->id,
            'processor_transaction_ref' => $event->params['transaction_ref']
        ])
        ->first();

        if ($payment) {
            // update payment;
            $payment->status = 'failed';
            $payment->save();
        }
    }
}
