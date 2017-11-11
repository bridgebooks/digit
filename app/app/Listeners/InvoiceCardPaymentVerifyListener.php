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
        // convert response to object
        $requestResponse = json_encode($event->response->getData());
        $response = json_decode($requestResponse);

        // Update invoice payment
        $payment = $this->paymentRepository->skipPresenter()
            ->findWhere([
                'invoice_id' => $event->invoice->id, 
                'processor_transaction_ref' => $event->params['transaction_ref']
            ])
            ->first();

        if ($payment && in_array($response->flutterChargeResponseCode, ['0', '00', 'RR-00'])) {
            // update payment
            $payment->status = 'verified';
            $payment->save();
            // update invoice
            $event->invoice->status = 'paid';
            $event->invoice->save();
        } else {
            // update payment;
            $payment->status = 'failed';
            $payment->save();
        }
    }
}
