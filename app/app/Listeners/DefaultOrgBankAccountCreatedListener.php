<?php

namespace App\Listeners;

use App\Events\DefaultOrgBankAccountCreated;
use App\Repositories\OrgInvoiceSettingRepository;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class DefaultOrgBankAccountCreatedListener
{
    private $repository;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(OrgInvoiceSettingRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Handle the event.
     *
     * @param  DefaultOrgBankAccountCreated  $event
     * @return void
     */
    public function handle(DefaultOrgBankAccountCreated $event)
    {
        $account = $event->account;
        $settings = $this->repository->skipPresenter(true)->byOrgID($account->org_id);

        if (!empty($settings)) {
            $this->repository->update([
                'org_bank_account_id' => $account->id
            ], $settings->id);
        }
    }
}
