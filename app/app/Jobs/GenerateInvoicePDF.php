<?php

namespace App\Jobs;

use PDF;
use Storage;
use CloudinaryImage as Cloudinary;
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

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $invoice = $this->invoice;
        
        $name = $invoice->invoice_no.'_'. time(). '.pdf';

        $pdf = PDF::loadView('invoices.standard', compact('invoice'));

        Storage::disk('azure')->put($name, $pdf->output());

        $url = Storage::disk('azure')->url($name);
        $invoice->pdf_url = $url;
        $invoice->save();
    }
}
