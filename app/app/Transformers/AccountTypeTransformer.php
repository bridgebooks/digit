<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\AccountType;

/**
 * Class AccountTypeTransformer
 * @package namespace App\Transformers;
 */
class AccountTypeTransformer extends TransformerAbstract
{

    /**
     * Transform the \AccountType entity
     * @param \AccountType $model
     *
     * @return array
     */
    public function transform(AccountType $model)
    {
        return [
            'id' => (int) $model->id,
            'name' => $model->name,
            'normal_balance' => $model->normal_balance
        ];
    }
}
