<?php

namespace App\Mail;

use App\Models\Invoice;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class InvoiceEmailMessage extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $invoice;
    public $params;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Invoice $invoice, array $params)
    {
        $this->invoice = $invoice;
        $this->params = $params;
        $this->params['url'] = config('app.invoice_viewer_url') .'/'. $this->invoice->id;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.invoices.message')
            ->subject($this->params['subject']);
    }
}
