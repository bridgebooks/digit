<?php

namespace App\Listeners;

use App\Events\InvoiceAuthorized;
use App\Repositories\TransactionRepository;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Notifications\InvoiceAuthorized as InvoiceAuthorizedNotification;

class InvoiceAuthorizedListener
{
    protected $transactionRepo;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(TransactionRepository $transactionRepository)
    {
        $this->transactionRepo = $transactionRepository;
    }

    /**
     * Handle the event.
     *
     * @param  InvoiceAuthorized  $event
     * @return void
     */
    public function handle(InvoiceAuthorized $event)
    {
        // send InvoiceAuthorized email
        $user = $event->invoice->user;
        $user->notify(new InvoiceAuthorizedNotification($event->invoice));
        // commit transaction
    }
}
