<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\PayslipItem;

/**
 * Class PayslipItemTransformer
 * @package namespace App\Transformers;
 */
class PayslipItemTransformer extends TransformerAbstract
{
    protected $defaultIncludes = ['item'];

    /**
     * @param PayslipItem $model
     * @return \League\Fractal\Resource\Item
     */
    public function includeItem(PayslipItem $model)
    {
        $item = $model->item;

        return $this->item($item, new PayitemTransformer);
    }

    /**
     * Transform the \PayslipItem entity
     * @param \PayslipItem $model
     *
     * @return array
     */
    public function transform(PayslipItem $model)
    {
        return [
            'id' => $model->id,
            'pay_slip_id' => $model->pay_slip_id,
            'pay_item_id' => $model->pay_item_id,
            'amount' => (float) $model->amount,
            'created_at' => $model->created_at->getTimestamp() * 1000,
            'updated_at' => $model->updated_at->getTimestamp() * 1000
        ];
    }
}
