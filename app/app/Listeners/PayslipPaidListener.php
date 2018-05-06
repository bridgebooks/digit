<?php

namespace App\Listeners;

use App\Events\PayslipPaid;
use App\Repositories\TransactionRepository;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class PayslipPaidListener
{
    protected $transactions;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(TransactionRepository $transactions)
    {
        $this->transactions = $transactions;
    }

    /**
     * Handle the event.
     *
     * @param  PayslipPaid  $event
     * @return void
     */
    public function handle(PayslipPaid $event)
    {
        $this->transactions->commitPayslipPayment($event->payslip, $event->payment);
    }
}
