<?php

namespace App\Listeners;

use App\Events\TransactionCreated;
use App\Models\Enums\AccountType;
use App\Repositories\OrgAccountSettingRepository;
use App\Repositories\TransactionRepository;
use Carbon\Carbon;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class TransactionCreatedListener implements ShouldQueue
{
    use InteractsWithQueue;

    protected $transactionRepository;
    protected $accountSettingsRepository;


    /**
     * TransactionCreatedListener constructor.
     * @param TransactionRepository $transactionRepository
     * @param OrgAccountSettingController $accountSettingsRepository
     */
    public function __construct(TransactionRepository $transactionRepository, OrgAccountSettingRepository $accountSettingsRepository)
    {
        $this->transactionRepository = $transactionRepository;
        $this->accountSettingsRepository = $accountSettingsRepository;
    }

    /**
     * Fetch org account settings
     * @param string $id
     * Org model id
     * @return mixed
     */
    private function getAccountSettings(string $id)
    {
        $this->accountSettingsRepository->skipPresenter();
        return $this->accountSettingsRepository->byOrgID($id);
    }

    /**
     * @param $financialYear
     * @return Carbon
     */
    private function getStartDate($financialYear)
    {
        $date = new Carbon();

        $date->subYear();
        $date->month($financialYear->month);
        $date->day($financialYear->day);
        $date->hour(0);
        $date->minute(0);

        return $date->addDay();
    }
    /**
     * Handle the event.
     *
     * @param  TransactionCreated  $event
     * @return void
     */
    public function handle(TransactionCreated $event)
    {
        $account = $event->account;
        $settings = $this->getAccountSettings($event->account->org_id);
        $endDate = Carbon::now();

        if ($account->type->name === AccountType::EXPENSES || $account->type->name === AccountType::REVENUE) {
            $startDate = $this->getStartDate($settings->values->financial_year);
            $transactions = $this->transactionRepository->between($account->id, $startDate, $endDate);
        } else {
            $transactions = $this->transactionRepository->between($account->id, null, $endDate);
        }

        $debits = $transactions->map(function ($transaction) {
            return $transaction->debit;
        })->sum();

        $credits = $transactions->map(function ($transaction) {
            return $transaction->credit;
        })->sum();

        if ($account->type->normal_balance === "credit") {
            $ytd = $credits - $debits;
        } else {
            $ytd = $debits - $credits;
        }

        $account->ytd_balance = $ytd;
        $account->save();
    }
}
