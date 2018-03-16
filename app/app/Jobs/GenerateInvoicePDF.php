<?php

namespace App\Jobs;

use PDF;
use Storage;
use View;
use App\Models\Invoice;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class GenerateInvoicePDF implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $invoice;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Invoice $invoice)
    {
        $this->invoice = $invoice;
    }

    private function getInvoiceSettings(Invoice $invoice)
    {
        $settings = $this->invoice->org->invoiceSettings;

        return $settings;
    }

    /**
     * @param Invoice $invoice
     * @return mixed
     */
    private function makePDF(Invoice $invoice)
    {
        $html = View::make('invoices.standard', ['invoice' => $invoice])->render();
        $html = preg_replace('/>\s+</', '><', $html);

        return PDF::loadHtml($html);
    }

    /**
     * @param Invoice $invoice
     * @return mixed
     */
    private function savePDF(Invoice $invoice)
    {
        $pdf = $this->makePDF($invoice);
        $name = $invoice->invoice_no.'_'. $invoice->created_at->getTimestamp(). '.pdf';


        Storage::disk('azure')->put($name, $pdf->output());
        $url = Storage::disk('azure')->url($name);

        return $url;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $invoice = $this->invoice;
        $settings = $this->getInvoiceSettings($this->invoice);
        
        $url = $this->savePDF($invoice);

        $invoice->pdf_url = $url;
        $invoice->save();

        // delete job from queue
        $this->delete();
    }
}
