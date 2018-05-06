<?php

namespace App\Repositories;

use App\Models\InvoiceLineItem;
use App\Models\InvoicePayment;
use App\Models\OrgAccountSetting;
use App\Models\OrgPayrunSetting;
use App\Models\Payrun;
use App\Models\Payslip;
use App\Presenters\TransactionPresenter;
use Carbon\Carbon;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Models\Transaction;
use App\Models\Invoice;
use App\Models\Account;

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
     * Specify Presenter class name
     *
     * @return string
     */
    public function presenter()
    {
        return TransactionPresenter::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    /**
     * @param string $id
     * @param Carbon|null $start
     * @param Carbon $end
     * @return mixed
     */
    public function between(string $id, Carbon $start = null, Carbon $end)
    {
        $query = $this->model->where('account_id', $id);

        if (is_null($start)) {
            $query->where('created_at', '<=', $end->toDateTimeString());
        } else {
            $query->whereBetween('created_at', [
                $start->toDateTimeString(),
                $end->toDateTimeString(),
            ]);
        };

        return $query->get();
    }

    /**
     * @param string $id
     * @param Carbon|null $start
     * @param Carbon $end
     * @return mixed
     */
    public function allBetween(string $id, Carbon $start = null, Carbon $end)
    {
        $query = $this->model->where('org_id', $id);

        if (is_null($start)) {
            $query->where('created_at', '<=', $end->toDateTimeString());
        } else {
            $query->whereBetween('created_at', [
                $start->toDateTimeString(),
                $end->toDateTimeString(),
            ]);
        };

        return $query->get();
    }

    private function getAccount(string $id)
    {
        return Account::with(['type'])->find($id);
    }

    private function getAccountSettings(string $id)
    {
        return OrgAccountSetting::where('org_id', $id)->first();
    }

    /**
     * Get org payrun settings
     * @param string $id
     * @return mixed
     */
    private function getPayrunSettings(string $id)
    {
        return OrgPayrunSetting::where('org_id', $id)->first();
    }

    private function postInvoice(Invoice $invoice, Account $account, bool $tax = false)
    {
        // Create transaction
        $transaction = new Transaction();
        $transaction->source_id = $invoice->id;
        $transaction->source_type = get_class($invoice);
        $transaction->org_id = $invoice->org_id;
        $transaction->account_id = $account->id;

        if ($tax) {
            if ($account->type->normal_balance === 'credit' && $invoice->type === 'acc_pay') {
                $transaction->debit = $invoice->tax_total;
            } else {
                $transaction->credit = $invoice->tax_total;
            }
        } else {
            if ($account->type->normal_balance === 'credit') {
                $transaction->credit = $invoice->total;
            } else {
                $transaction->debit = $invoice->total;
            }
        }

        $transaction->save();
    }

    private function postInvoicePayment(Invoice $invoice, Account $account, InvoicePayment $payment)
    {
        // Create transaction
        $transaction = new Transaction();
        $transaction->source_id = $payment->id;
        $transaction->source_type = get_class($payment);
        $transaction->org_id = $invoice->org_id;
        $transaction->account_id = $account->id;

        if ($account->type->normal_balance === 'credit') {
            $transaction->debit = $invoice->total;
        } else {
            $transaction->credit = $invoice->total;
        }

        $transaction->save();
    }

    private function postPayslipPayment(Payslip $slip, Account $account, InvoicePayment $payment)
    {
        // Create transaction
        $transaction = new Transaction();
        $transaction->source_id = $payment->id;
        $transaction->source_type = get_class($payment);
        $transaction->org_id = $slip->payrun->org_id;
        $transaction->account_id = $account->id;

        if ($account->type->normal_balance === 'credit') {
            $transaction->debit = $slip->net_pay;
        } else {
            $transaction->credit = $slip->net_pay;
        }

        $transaction->save();
    }

    private function postInvoiceItemPayment(Invoice $invoice, InvoiceLineItem $item, Account $account, InvoicePayment $payment)
    {
        // Create transaction
        $transaction = new Transaction();
        $transaction->source_id = $payment->id;
        $transaction->source_type = get_class($payment);
        $transaction->org_id = $invoice->org_id;
        $transaction->account_id = $account->id;

        if ($account->type->normal_balance === 'credit') {
            $transaction->debit = $item->amount;
        } else {
            $transaction->credit = $item->amount;
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
                $account = $this->getAccount($settings->values->accounts_receivable);
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

    public function postPayslipItems(Payslip $slip)
    {
        $slip->items->filter(function ($slipItem) {
            return $slipItem->item->pay_item_type !== 'wage';
        })->each(function ($slipItem) {
           $account = $this->getAccount($slipItem->item->account_id);
            // Create transaction
            $transaction = new Transaction();
            $transaction->source_id = $slipItem->payslip->id;
            $transaction->source_type = get_class($slipItem->payslip);
            $transaction->org_id = $slipItem->payslip->payrun->org_id;
            $transaction->account_id = $account->id;

            if ($account->type->normal_balance === 'credit') {
                $transaction->credit = $slipItem->amount;
            } else {
                $transaction->debit = $slipItem->amount;
            }

            $transaction->save();
        });
    }

    /**
     * @param Payrun $payrun
     * @param OrgPayrunSettingRepositoryEloquent $settingsRepository
     */
    public function commitPayrun(Payrun $payrun, OrgPayrunSettingRepositoryEloquent $settingsRepository)
    {
        $settingsRepository->skipPresenter();
        $settings = $settingsRepository->byOrgID($payrun->org_id);
        $accountSettings = $this->getAccountSettings($payrun->org_id);

        $wagePayable = $this->getAccount($settings->values->wages_account);
        $employeeTaxPayable = $this->getAccount($settings->values->employee_tax_account);
        $wages = $accountSettings ? $this->getAccount($accountSettings->values->wages) : null;

        $payrun->payslips->each(function ($payslip) use ($wagePayable, $employeeTaxPayable, $wages) {
           // post wage payable
           $this->postPayslip($payslip, $wagePayable);
           // post tax payable
           $this->postPayslip($payslip, $employeeTaxPayable, true);
           // post payslip items
           $this->postPayslipItems($payslip);
           // post wages
           if ($wages) $this->postPayslip($payslip, $wages);
        });
    }

    /**
     * @param Invoice $invoice
     * @param InvoicePayment $payment
     */
    public function commitInvoicePayment(Invoice $invoice, InvoicePayment $payment)
    {
        $settings = $this->getAccountSettings($invoice->org_id);
        $account = $invoice->type === "acc_rec"
            ? $this->getAccount($settings->values->accounts_receivable)
            : $this->getAccount($settings->values->accounts_payable);
        $this->postInvoicePayment($invoice, $account, $payment);

        /*
        $invoice->items->each(function ($item) use ($invoice, $payment) {
           $account = $this->getAccount($item->account_id);
           $this->postInvoiceItemPayment($invoice, $item, $account, $payment);
        });*/
    }

    public function commitPayslipPayment(Payslip $slip, InvoicePayment $payment)
    {
        $settings = $this->getPayrunSettings($slip->payrun->org_id);
        $account = $this->getAccount($settings->values->wages_account);
        $this->postPayslipPayment($slip, $account, $payment);
    }
}
