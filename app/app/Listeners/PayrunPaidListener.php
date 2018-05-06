<?php

namespace App\Listeners;

use App\Events\PayrunPaid;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class PayrunPaidListener
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
     * @param  PayrunPaid  $event
     * @return void
     */
    public function handle(PayrunPaid $event)
    {
        //
    }
}
