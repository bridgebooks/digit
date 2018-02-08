<?php

namespace App\Listeners;

use App\Events\CommitPayrun;
use App\Repositories\TransactionRepository;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class CommitPayrunListener implements ShouldQueue
{
    use InteractsWithQueue;

    protected $repository;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(TransactionRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Handle the event.
     *
     * @param  CommitPayrun  $event
     * @return void
     */
    public function handle(CommitPayrun $event)
    {
        $this->repository->commitPayun($event->payrun);
        // remove job from queue
        $this->delete();
    }
}
