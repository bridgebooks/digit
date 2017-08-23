<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\Bank;

/**
 * Class BankTransformer
 * @package namespace App\Transformers;
 */
class BankTransformer extends TransformerAbstract
{

    /**
     * Transform the \Bank entity
     * @param \Bank $model
     *
     * @return array
     */
    public function transform(Bank $model)
    {
        return [
            'id' => $model->id,
            'name' => $model->name,
            'identifier' => $model->identifier,
            'country' => $model->country
        ];
    }
}
