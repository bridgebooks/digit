<?php

namespace App\Models\Observers;

use App\Events\InvoiceAuthorized;
use Log;
use App\Jobs\SendInvoiceEmail;
use App\Models\Enums\InvoiceStatus;
use App\Models\Invoice;

class InvoiceObserver
{
    /**
     * @access private
     * Generate an email message for an invoice
     * @param App\Models\Invoice $invoice
     * @return string
     */
    private function generateInvoiceMessage(Invoice $invoice)
    {
        $messageString = 'Hi %s, Here\'s invoice %s for %d.
      The amount outstanding of %d is due on %s.
      View and pay your bill online.
      If you have any questions, please let us know.
      Thanks,
      %s';

        return sprintf($messageString, 
            $invoice->contact->name,
            $invoice->invoice_no,
            $invoice->total,
            $invoice->total,
            date('d M, Y', $invoice->due_at->getTimestamp()),
            $invoice->org->name);
    }

     /**
     * @access private
     * Generate an email subject for an invoice
     * @param App\Models\Invoice $invoice
     * @return string
     */
    private function generateInvoiceMessageSubject(Invoice $invoice)
    {
        $messageString = 'Invoice %s from %s for %s';
        return sprintf($messageString, $invoice->invoice_no, $invoice->org->name, $invoice->contact->name);
    }

    private function generateInvoice(Invoice $invoice)
    {
        event(new \App\Events\InvoiceSubmitted($invoice));
    }

    private function  generateInvoiceAndSend(Invoice $invoice)
    {
        $contact = $invoice->contact;

        if (!is_null($contact->email)) {
            $params = [
                'to' => $contact->email,
                'subject' => $this->generateInvoiceMessageSubject($invoice),
                'message' => $this->generateInvoiceMessage($invoice),
                'send_copy' => false,
                'attach_pdf' => true,
                'mark_sent' => true
            ];

            \App\Jobs\GenerateInvoicePDF::dispatch($invoice)->chain([
                new SendInvoiceEmail($invoice, $params)
            ]);
        } else {
            // Send no email notification
            event(new \App\Events\InvoiceNoContactError($invoice));
        }
    }

    private function sendInvoice(Invoice $invoice)
    {
        $contact = $invoice->contact;

        if (!is_null($contact->email)) {
            $params = [
                'to' => $contact->email,
                'subject' => $this->generateInvoiceMessageSubject($invoice),
                'message' => $this->generateInvoiceMessage($invoice),
                'send_copy' => false,
                'attach_pdf' => true,
                'mark_sent' => true
            ];

            dispatch(new SendInvoiceEmail($invoice, $params));
        } else {
            // Send no email notification
            event(new \App\Events\InvoiceNoContactError($invoice));
        }
    }

    /**
     * Listen to the Invoice created event.
     *
     * @param  Invoice  $user
     * @return void
     */
    public function created(Invoice $invoice)
    {
        if ($invoice->status == InvoiceStatus::AUTHORIZED) {
            if ( !is_null($invoice->pdf_url)) {
                $this->sendInvoice($invoice);   
            } else {
                $this->generateInvoiceAndSend($invoice);
            }
        }

        if ($invoice->status == InvoiceStatus::SUBMITTED) {
            $this->generateInvoice($invoice);
        }
    }

    /**
     * Listen to the Invoice updated event.
     *
     * @param  Invoice  $user
     * @return void
     */
    public function updated(Invoice $invoice)
    {
        if ($invoice->status == InvoiceStatus::AUTHORIZED) {
            if ( !is_null($invoice->pdf_url)) {
                $this->sendInvoice($invoice);   
            } else {
                $this->generateInvoiceAndSend($invoice);
            }

            event(new InvoiceAuthorized($invoice));
        }

        if ($invoice->status == InvoiceStatus::SUBMITTED) {
            $this->generateInvoice($invoice);
        }
    }
}