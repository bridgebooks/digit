<?php

namespace App\Jobs;

use Mail;
use App\Models\Invoice;
use App\Mail\InvoiceEmailMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendInvoiceEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $invoice;
    protected $params;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Invoice $invoice, array $params)
    {
        $this->invoice = $invoice;
        $this->params = $params;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $to = explode(',', $this->params['to']);
        $mail = new InvoiceEmailMessage($this->invoice, $this->params);

        if ($this->params['send_copy']) {
            Mail::to($to)
                ->cc($this->invoice->user->email)
                ->send($mail);
        } else {
            Mail::to($to)
                ->send($mail);
        }

        // delete job from queue
        $this->delete();
    }
}
