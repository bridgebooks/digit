<?php

namespace App\Listeners;

use App\Models\Libs\SubscriptionBuilder;
use App\Models\Plan;
use Carbon\Carbon;
use App\Events\PrimaryUserCreated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class PrimaryUserCreatedListener implements ShouldQueue
{
    use InteractsWithQueue;
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
     * @param  PrimaryUserCreated  $event
     * @return void
     */
    public function handle(PrimaryUserCreated $event)
    {
        // Create paystack customer
        $event->user->createPaystackCustomer();
        // Plan
        $plan = Plan::where('name', $event->plan)->first();
        // Create subscription
        $event->user->newSubscription($plan)->create([ 'skip_paystack' => true ]);
    }
}
