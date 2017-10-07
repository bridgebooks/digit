<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\InvoiceRepository;
use App\Models\Invoice;
use App\Presenters\InvoicePresenter;

/**
 * Class InvoiceRepositoryEloquent
 * @package namespace App\Repositories;
 */
class InvoiceRepositoryEloquent extends BaseRepository implements InvoiceRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Invoice::class;
    }

    /**
     * Specify Presenter class name
     *
     * @return string
     */
    public function presenter()
    {
        return InvoicePresenter::class;
    }
    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    public function updateInvoiceItems(Invoice $invoice, array $items) 
    {
        $invoice->items()->delete();

        $lineItems = [];

        foreach ($items as $item) {
            $lineItems[] = [
                'row_order' => $item['row_order'],
                'item_id' => $item['item_id'],
                'description' => $item['description'],
                'quantity' => $item['quantity'],
                'unit_price' => $item['unit_price'],
                'discount_rate' => empty($item['discount_rate']) ? null : $item['discount_rate'],
                'account_id' => $item['account_id'],
                'tax_rate_id' => $item['tax_rate_id'],
                'amount' => $item['amount'],
            ];
        }

        $invoice->items()->createMany($lineItems);
    }
}
