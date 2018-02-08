<?php

namespace App\Repositories;

use App\Models\Payrun;
use App\Models\Payslip;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\TransactionRepository;
use App\Models\Transaction;
use App\Models\Invoice;
use App\Models\Account;
use OrgAccountSettingRepository;
/**
 * Class TransactionRepositoryEloquent
 * @package namespace App\Repositories;
 */
class TransactionRepositoryEloquent extends BaseRepository implements TransactionRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Transaction::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    private function getAccount(string $id)
    {
        return Account::with(['type'])->find($id);
    }

    private function postInvoice(Invoice $invoice, Account $account, bool $tax = false)
    {
        // Create transaction
        $transaction = new Transaction();
        $transaction->source_id = $invoice->id;
        $transaction->source_type = get_class($invoice);
        $transaction->org_id = $invoice->org_id;
        $transaction->account_id = $account->id;
        
        if ($account->type->normal_balance === 'credit') {
            $transaction->credit = $tax ? $invoice->tax_total : $invoice->total;
        } else {
            $transaction->debit = $tax ? $invoice->tax_total : $invoice->total;
        }

        $transaction->save();
    }

    private function postInvoiceItems(Invoice $invoice)
    {
        $items = $invoice->items;
        $itemGroups = $items->groupBy("account_id");
        $itemGroups->each(function ($group) use ($invoice) {
            $account = $this->getAccount($group[0]->account_id);
            $total = $group->map(function ($item) {
                return $item->amount;
            })->sum();

            // Create transaction
            $transaction = new Transaction();
            $transaction->source_id = $invoice->id;
            $transaction->source_type = get_class($invoice);
            $transaction->org_id = $invoice->org_id;
            $transaction->account_id = $account->id;

            if ($account->type->normal_balance === 'credit') {
                $transaction->credit = $total;
            } else {
                $transaction->debit = $total;
            }

            $transaction->save();
        });
    }


    /**
     * @param Invoice $invoice
     * @param OrgAccountSettingRepositoryEloquent $settingsRepository
     */
    public function commitInvoice(Invoice $invoice, OrgAccountSettingRepositoryEloquent $settingsRepository)
    {
        $settingsRepository->skipPresenter();
        $settings = $settingsRepository->byOrgID($invoice->org_id);
        
        switch ($invoice->type) {
            case 'acc_rec':
                $account = $this->getAccount($settings->values->accounts_recievable);
            break;
            case 'acc_pay':
                $account = $this->getAccount($settings->values->accounts_payable);
            break;
        }

        $taxAccount = $this->getAccount($settings->values->sales_tax);

        $this->postInvoice($invoice, $account);
        $this->postInvoice($invoice, $taxAccount, true);
        $this->postInvoiceItems($invoice);
    }

    public function postPayslip(Payslip $slip, Account $account, bool $tax = false)
    {
        if ($account) {
            // Create transaction
            $transaction = new Transaction();
            $transaction->source_id = $slip->id;
            $transaction->source_type = get_class($slip);
            $transaction->org_id = $slip->payrun->org_id;
            $transaction->account_id = $account->id;

            if ($account->type->normal_balance === 'credit') {
                $transaction->credit = $tax ? $slip->tax : $slip->net_pay;
            } else {
                $transaction->debit = $tax ? $slip->tax : $slip->net_pay;
            }

            $transaction->save();
        }
    }

    /**
     * @param Payrun $payrun
     * @param OrgAccountSettingRepositoryEloquent $settingsRepository
     */
    public function commitPayrun(Payrun $payrun, OrgAccountSettingRepositoryEloquent $settingsRepository)
    {
        $settingsRepository->skipPresenter();
        $settings = $settingsRepository->byOrgID($payrun->org_id);

        $wagePayable = $this->getAccount($settings->values->wages_account);
        $employeeTaxPayable = $this->getAccount($settings->values->employee_tax_account);

        $payrun->payslips->each(function ($payslip) use ($wagePayable, $employeeTaxPayable) {
           $this->postPayslip($payslip, $wagePayable);
           //post taxes
            $this->postPayslip($payslip, $employeeTaxPayable, true);
        });
    }
}
