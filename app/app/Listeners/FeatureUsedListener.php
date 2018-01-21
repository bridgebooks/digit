<?php

namespace App\Listeners;

use App\Events\FeatureUsed;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class FeatureUsedListener implements ShouldQueue
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
     * @param  FeatureUsed  $event
     * @return void
     */
    public function handle(FeatureUsed $event)
    {
        $event->subscription->recordFeatureUsage($event->featureName);

        $this->delete();
    }
}
