<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\Subscription;

/**
 * Class SubscriptionTransformer.
 *
 * @package namespace App\Transformers;
 */
class SubscriptionTransformer extends TransformerAbstract
{
    protected $availableIncludes = ['plan'];

    public function includePlan(Subscription $model)
    {
        $plan = $model->plan;

        return $this->item($plan, new PlanTransformer);
    }
    /**
     * Transform the Subscription entity.
     *
     * @param \App\Models\Subscription $model
     *
     * @return array
     */
    public function transform(Subscription $model)
    {
        return [
            'id' => $model->id,
            'plan_id' => $model->plan_id,
            'user_id' => $model->user_id,
            'quantity' => $model->quantity,
            'paystack_subscription_code' => $model->paystack_subscription_code,
            'paystack_subscription_token' => $model->paystack_subscription_token,
            'is_trial' => $model->onTrial(),
            'is_canceled' => $model->canceled(),
            'is_ended' => $model->ended(),
            'is_active' => $model->active(),
            'trial_ends_at' => $model->trial_ends_at ? $model->trial_ends_at->getTimestamp() * 1000 : null,
            'starts_at' => $model->starts_at ? $model->starts_at->getTimestamp() * 1000 : null,
            'ends_at' => $model->ends_at ? $model->ends_at->getTimestamp() * 1000 : null,
            'canceled_at' => $model->canceled_at ? $model->canceled_at->getTimestamp() * 1000 : null,
            'created_at' => $model->created_at->getTimestamp() * 1000,
            'updated_at' => $model->updated_at->getTimestamp() * 1000
        ];
    }
}
