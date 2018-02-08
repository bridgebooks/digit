<?php

namespace App\Listeners;

use App\Events\CommitInvoice;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Repositories\TransactionRepository;
use App\Repositories\OrgAccountSettingRepository;

class CommitInvoiceListener implements ShouldQueue
{
    use InteractsWithQueue;
    
    protected $repository;
    protected $settings;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(TransactionRepository $repository, OrgAccountSettingRepository $settings)
    {
        $this->repository = $repository;
        $this->settings = $settings;
    }

    /**
     * Handle the event.
     *
     * @param  CommitInvoice  $event
     * @return void
     */
    public function handle(CommitInvoice $event)
    {
        $this->repository->commitInvoice($event->invoice, $this->settings);
        $this->delete();
    }
}
