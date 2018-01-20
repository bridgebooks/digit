<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\Plan;

/**
 * Class PlanTransformer.
 *
 * @package namespace App\Transformers;
 */
class PlanTransformer extends TransformerAbstract
{
    /**
     * Transform the Plan entity.
     *
     * @param \App\Models\Plan $model
     *
     * @return array
     */
    public function transform(Plan $model)
    {
        return [
            'id' => $model->id,
            'display_name' => $model->display_name,
            'name' => $model->name,
            'description' => $model->description,
            'invoice_interval' => $model->invoice_interval,
            'invoice_period' => $model->invoice_period,
            'trial_interval' => $model->trial_interval,
            'trial_period' => $model->trial_period,
            'amount' => (float) $model->amount,
            'currency' => $model->currency,
            'paystack_plan_code' => $model->paystack_plan_code,
            'created_at' => $model->created_at->getTimestamp() * 1000,
            'updated_at' => $model->updated_at->getTimestamp() * 1000
        ];
    }
}
