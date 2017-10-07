<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\InvoiceLineItem;
use App\Models\TaxRate;

/**
 * Class InvoiceLineItemTransformer
 * @package namespace App\Transformers;
 */
class InvoiceLineItemTransformer extends TransformerAbstract
{

    private function getTaxRateValue(TaxRate $rate)
    {
        $total = 0;

        foreach($rate->components as $component) {
            $total += $component->value;
        }

        return $total;
    }
    /**
     * Transform the \InvoiceLineItem entity
     * @param \InvoiceLineItem $model
     *
     * @return array
     */
    public function transform(InvoiceLineItem $model)
    {
        return [
            'id' => $model->id,
            'row_order' => $model->row_order,
            'invoice_id' => $model->invoice_id,
            'item_id' => $model->item_id,
            'item' => $model->item,
            'description' => $model->description,
            'unit_price' => (float) $model->unit_price,
            'quantity' => $model->quantity,
            'discount_rate' => $model->discount_rate,
            'account_id' => $model->account_id,
            'account' => $model->account,
            'tax_rate_id' => $model->tax_rate_id,
            'tax_rate' => [
                'id' => $model->taxRate->id,
                'name' => $model->taxRate->name,
                'is_system' => (bool) $model->taxRate->is_system,
                'value' => $this->getTaxRateValue($model->taxRate)
            ],
            'amount' => (float) $model->amount,
            'created_at' => $model->created_at->getTimestamp() * 1000,
            'updated_at' => $model->updated_at->getTimestamp() * 1000
        ];
    }
}
