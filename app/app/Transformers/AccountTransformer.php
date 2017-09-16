<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\Account;
use App\Transformers\AccountTypeTransformer;

/**
 * Class AccountTransformer
 * @package namespace App\Transformers;
 */
class AccountTransformer extends TransformerAbstract
{
    protected $availableIncludes = ['type', 'tax_rate'];

    /**
     * @param Account $account
     * @return \League\Fractal\Resource\Item
     */
    public function includeType(Account $account)
    {
        $type = $account->type;

        if ($type) return $this->item($type, new AccountTypeTransformer);
    }
    
    /**
     * Transform the \Account entity
     * @param \Account $model
     *
     * @return array
     */
    public function transform(Account $model)
    {
        return [
            'id' => $model->id,
            'is_system' => (bool) $model->is_system,
            'account_type_id' => $model->account_type_id,
            'org_id' => $model->org_id,
            'name' => $model->name,
            'code' => $model->code,
            'description' => $model->description,
            'tax_rate_id' => $model->tax_rate_id,
            'created_at' => $model->created_at
        ];
    }
}
