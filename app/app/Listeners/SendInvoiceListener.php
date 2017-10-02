<?php

namespace App\Listeners;

use Mail;
use App\Traits\UserRequest;
use App\Events\SendInvoice;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Mail\InvoiceEmailMessage;

class SendInvoiceListener implements ShouldQueue
{
    use InteractsWithQueue, UserRequest;


    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Handle the event.
     *
     * @param  SendInvoice  $event
     * @return void
     */
    public function handle(SendInvoice $event)
    {
        $to = explode(',', $event->params['to']);
        $mail = new InvoiceEmailMessage($event->invoice, $event->params);

        if ($event->params['send_copy']) {
            Mail::to($to)
                ->cc($event->invoice->user->email)
                ->send($mail);
        } else {
            Mail::to($to)
                ->send($mail);
        }
    }
}
