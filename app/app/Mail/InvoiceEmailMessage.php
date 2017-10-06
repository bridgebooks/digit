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

    private function sendWithAttachment() 
    {

        $attachment = file_get_contents($this->invoice->pdf_url);
        $name = $this->invoice->invoice_no.'.pdf';

        return $this->view('emails.invoices.message')
            ->subject($this->params['subject'])
            ->attachData($attachment, $name, [
                'mime' => 'application/pdf'
            ]);
    }

    private function sendWithoutAttachment()
    {
        return $this->view('emails.invoices.message')->subject($this->params['subject']);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if ($this->params['attach_pdf']) {
            $this->sendWithAttachment();
        } else {
            $this->sendWithoutAttachment();
        }
    }
}
