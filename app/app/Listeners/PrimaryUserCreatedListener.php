<?php

namespace App\Listeners;

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
        $event->user->trial_ends_at = Carbon::now()->addDays($event->trial_days);
        $event->user->save();
    }
}
