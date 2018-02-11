<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\Transaction;

/**
 * Class TransactionTransformer.
 *
 * @package namespace App\Transformers;
 */
class TransactionTransformer extends TransformerAbstract
{
    protected $availableIncludes = [ 'account', 'source' ];

    private function parseSourceType(string $type)
    {
        switch($type) {
            case 'App\Models\Invoice':
                return "Invoice";
                break;
            case 'App\Models\Payslip':
                return "Payslip";
                break;
            case 'App\Models\InvoicePayment':
                return "InvoicePayment";
                break;
        }
    }

    public function includeAccount(Transaction $model)
    {
        $account = $model->account;

        return $this->item($account, new AccountTransformer);
    }

    public function includeSource(Transaction $model)
    {
        $source = $model->source;

        if ($source instanceof \App\Models\Invoice) {
            return $this->item($source, new InvoiceTransformer);
        } else if ($source instanceof \App\Models\Payslip) {
            return $this->item($source, new PayslipTransformer);
        }
        else if ($source instanceof \App\Models\InvoicePayment) {
            return $this->item($source, new InvoicePaymentTransformer);
        }
    }

    /**
     * Transform the Transaction entity.
     *
     * @param \App\Models\Transaction $model
     *
     * @return array
     */
    public function transform(Transaction $model)
    {
        return [
            'id' => $model->id,
            'org_id' => $model->org_id,
            'account_id' => $model->account->id,
            'source_id' => $model->source_id,
            'source_type' => $this->parseSourceType($model->source_type),
            'credit' => (float) $model->credit,
            'debit' => (float) $model->debit,
            'created_at' => $model->created_at->getTimestamp() * 1000,
            'updated_at' => $model->updated_at->getTimestamp() * 1000
        ];
    }
}
