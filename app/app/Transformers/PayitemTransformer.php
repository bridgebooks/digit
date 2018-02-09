<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\Payitem;

/**
 * Class PayitemTransformer
 * @package namespace App\Transformers;
 */
class PayitemTransformer extends TransformerAbstract
{
    protected $defaultIncludes = ['account'];

    /**
     * @param Payitem $model
     * @return \League\Fractal\Resource\Item
     */
    public function includeAccount(Payitem $model)
    {
        $account = $model->account;

        return $this->item($account, new AccountTransformer);
    }

    /**
     * Transform the \Payitem entity
     * @param \Payitem $model
     *
     * @return array
     */
    public function transform(Payitem $model)
    {
        return [
            'id' => $model->id,
            'org_id' => $model->org_id,
            'account_id' => $model->account_id,
            'is_system' => $model->is_system,
            'pay_item_type' => $model->pay_item_type,
            'name' => $model->name,
            'default_amount' => $model->default_amount,
            'description' => $model->description,
            'default' => (bool) $model->mark_default,
            'is_archived' => $model->deleted_at ? true : false,
            'created_at' => $model->created_at->getTimestamp() * 1000,
            'updated_at' => $model->updated_at->getTimestamp() * 1000,
            'deleted_at' => $model->deleted_at ? $model->deleted_at->getTimestamp() * 1000 : null
        ];
    }
}
