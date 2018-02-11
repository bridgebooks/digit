<?php

namespace App\Mail;

use App\Models\Invoice;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class PaymentSuccess extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $invoice;
    public $params;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Invoice $invoice)
    {
        $this->invoice = $invoice;
        $this->params = $this->buildParams($invoice);
    }

    private function buildParams(Invoice $invoice)
    {
        $params = [];

        $params['url'] = config('app.frontend_url').'/invoices/view/'.$invoice->id;
        return $params;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.invoices.paid')
            ->subject('Invoice #'.$this->invoice->invoice_no.' Paid');
    }
}
