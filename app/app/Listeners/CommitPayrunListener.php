<?php

namespace App\Listeners;

use App\Events\CommitPayrun;
use App\Repositories\TransactionRepository;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Repositories\OrgPayrunSettingRepository;

class CommitPayrunListener implements ShouldQueue
{
    use InteractsWithQueue;

    protected $repository;
    protected $settings;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(TransactionRepository $repository, OrgPayrunSettingRepository $settings)
    {
        $this->repository = $repository;
        $this->settings = $settings;
    }

    /**
     * Handle the event.
     *
     * @param  CommitPayrun  $event
     * @return void
     */
    public function handle(CommitPayrun $event)
    {
        $this->repository->commitPayrun($event->payrun, $this->settings);
        // remove job from queue
        $this->delete();
    }
}
