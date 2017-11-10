<?php

namespace App\Listeners;

use App\Repositories\InvoicePaymentRepository;
use App\Events\InvoiceCardPaymentInit;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class InvoiceCardPaymentInitListener implements ShouldQueue
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

    private function generateTransactionRef(string $id)
    {
        return $id.time().uniqid(mt_rand(), true);
    }

    /**
     * Handle the event.
     *
     * @param  InvoiceCardPaymentInit  $event
     * @return void
     */
    public function handle(InvoiceCardPaymentInit $event)
    {
        $requestResponse = json_encode($event->response->getData());
        $response = json_decode($requestResponse);

        if ( in_array($response->transfer->flutterChargeResponseCode, ['0','00', '02']) ) {

            $attributes = [
                'invoice_id' => $event->invoice->id,
                'transaction_ref' => $this->generateTransactionRef($event->invoice->id),
                'processor_transaction_ref' => $response->transfer->flutterChargeReference,
                'amount' => $event->invoice->total,
                'processor_fee' => env('PAYMENT_PROCESSOR_FEE', 45),
                'fee' => env('PAYMENT_FEE', 0),
                'first_name' => $event->params->first_name,
                'last_name' => $event->params->last_name,
                'phone' => $event->params->phone,
                'email' => $event->params->email
            ];

            // create modal
            $this->paymentRepository->create($attributes);
        }
    }
}
