<?php

namespace App\Listeners;

use App\Events\InvoiceAuthorized;
use App\Repositories\TransactionRepository;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

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

    }
}
