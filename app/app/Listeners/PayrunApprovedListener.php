<?php

namespace App\Listeners;

use App\Events\CommitPayrun;
use App\Events\PayrunApproved;
use App\Jobs\GeneratePayslipPDF;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class PayrunApprovedListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param PayrunApproved $event
     * @return void
     */
    public function handle(PayrunApproved $event)
    {
        $payrun = $event->payrun;
        // generate payslips
        dispatch(new GeneratePayslipPDF($payrun));
        // commit payrun
        event(new CommitPayrun($payrun));
    }
}
