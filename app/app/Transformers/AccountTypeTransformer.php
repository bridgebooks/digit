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
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
