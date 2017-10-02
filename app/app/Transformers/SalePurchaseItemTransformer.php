<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\SalePurchaseItem;
use App\Transformers\AccountTransformer;
use App\Transformers\TaxRateTransformer;

/**
 * Class SaleItemTransformer
 * @package namespace App\Transformers;
 */
class SalePurchaseItemTransformer extends TransformerAbstract
{
    protected $availableIncludes = ['sale_account', 'purchase_account', 'sale_tax', 'purchase_tax'];

    /**
     * @param SalePurchaseItem
     * @return \League\Fractal\Resource\Item
     */
    public function includeSaleAccount(SalePurchaseItem $item)
    {
        $account = $item->saleAccount;

        if ($account) return $this->item($account, new AccountTransformer);
    }

    /**
     * @param SalePurchaseItem
     * @return \League\Fractal\Resource\Item
     */
    public function includeSaleTax(SalePurchaseItem $item)
    {
        $tax = $item->saleTaxRate;

        if ($tax) return $this->item($tax, new TaxRateTransformer);
    }

    /**
     * @param SalePurchaseItem
     * @return \League\Fractal\Resource\Item
     */
    public function includePurchaseAccount(SalePurchaseItem $item)
    {
        $account = $item->purchaseAccount;

        if ($account) return $this->item($account, new AccountTransformer);
    }

    /**
     * @param SalePurchaseItem
     * @return \League\Fractal\Resource\Item
     */
    public function includePurchaseTax(SalePurchaseItem $item)
    {
        $tax = $item->purchaseTaxRate;

        if ($tax) return $this->item($tax, new TaxRateTransformer);
    }

    /**
     * Transform the \SaleItem entity
     * @param \SaleItem $model
     *
     * @return array
     */
    public function transform(SalePurchaseItem $model)
    {
        return [
            'id' => $model->id,
            'org_id' => $model->org_id,
            'user_id' => $model->user_id,
            'name' => $model->name,
            'code' => $model->code,
            'is_sold' => (bool) $model->is_sold,
            'sale_unit_price' => $model->sale_unit_price,
            'sale_account_id' => $model->sale_account_id,
            'sale_tax_id' => $model->sale_tax_id,
            'sale_description' => $model->sale_description,
            'is_purchased' => (bool) $model->is_purchased,
            'purchase_unit_price' => $model->purchase_unit_price,
            'purchase_account_id' => $model->purchase_account_id,
            'purchase_tax_id' => $model->purchase_tax_id,
            'purchase_description' => $model->purchase_description,
        ];
    }
}
