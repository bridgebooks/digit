<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\TaxRateComponent;

/**
 * Class TaxRateComponentTransformer
 * @package namespace App\Transformers;
 */
class TaxRateComponentTransformer extends TransformerAbstract
{

    /**
     * Transform the \TaxRateComponent entity
     * @param \TaxRateComponent $model
     *
     * @return array
     */
    public function transform(TaxRateComponent $model)
    {
        return [
            'id' => $model->id,
            'tax_rate_id' => $model->tax_rate_id,
            'name' => $model->name,
            'compound' => (bool) $model->compound,
            'value' => $model->value
        ];
    }
}
