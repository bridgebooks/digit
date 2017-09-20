<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\TaxRate;
use App\Transformers\TaxRateComponentTransformer;

/**
 * Class TaxRateTransformer
 * @package namespace App\Transformers;
 */
class TaxRateTransformer extends TransformerAbstract
{
    protected $availableIncludes = ['components'];

    /**
     * @param Account $account
     * @return \League\Fractal\Resource\Item
     */
    public function includeComponents(TaxRate $rate)
    {
        $components = $rate->components;

        if ($components) return $this->collection($components, new TaxRateComponentTransformer);
    }

    private function getValue(TaxRate $rate)
    {
        $total = 0;
        
        if ($rate->components) {
            foreach ($rate->components as $component) {
                $total = $total + $component->value;
            }
        }

        return $total;
    }

    /**
     * Transform the \TaxRate entity
     * @param \TaxRate $model
     *
     * @return array
     */
    public function transform(TaxRate $model)
    {
        return [
            'id'  =>  $model->id,
            'org_id' => $model->org_id,
            'name' => $model->name,
            'is_system' => (bool) $model->is_system,
            'value' => $this->getValue($model)
        ];
    }
}
