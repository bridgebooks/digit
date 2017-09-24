<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\OrgBankAccount;

/**
 * Class OrgBankAccountTransformer
 * @package namespace App\Transformers;
 */
class OrgBankAccountTransformer extends TransformerAbstract
{

    /**
     * Transform the \OrgBankAccount entity
     * @param \OrgBankAccount $model
     *
     * @return array
     */
    public function transform(OrgBankAccount $model)
    {
        return [
            'id' => $model->id,
            'name' => $model->name,
            'org_id' => $model->org_id,
            'user_id' => $model->user_id,
            'bank_id' => $model->bank_id,
            'account_name' => $model->account_name,
            'account_number' => $model->account_number,
            'bank' => [
                'id' => $model->bank->id,
                'name' => $model->bank->name,
                'identifier' => $model->bank->identifier,
                'country' => $model->bank->country
            ],
            'is_default' => $model->is_default,
            'notes' => $model->notes,
            'created_at' => $model->created_at,
        ];
    }
}
