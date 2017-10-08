<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\OrgInvoiceSetting;

/**
 * Class OrgInvoiceSettingTransformer
 * @package namespace App\Transformers;
 */
class OrgInvoiceSettingTransformer extends TransformerAbstract
{
    protected $availableIncludes = ['org_bank_account'];

    public function includeOrgBankAccount(OrgInvoiceSetting $model)
    {
        $account = $model->bankAccount;

        return $this->item($account, new OrgBankAccountTransformer);
    }
    /**
     * Transform the \OrgInvoiceSetting entity
     * @param \OrgInvoiceSetting $model
     *
     * @return array
     */
    public function transform(OrgInvoiceSetting $model)
    {
        return [
            'org_id' => $model->org_id,
            'template' => $model->template,
            'paper_size' => $model->paper_size,
            'org_bank_account_id' => $model->org_bank_account_id,
            'payment_advice' => $model->payment_advice,
            'show_payment_advice' => (bool) $model->show_payment_advice,
            'updated_at' => $model->updated_at->getTimestamp() * 1000
        ];
    }
}
