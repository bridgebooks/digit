<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\InvoiceLineItemRepository;
use App\Models\InvoiceLineItem;
use App\Presenters\InvoiceLineItemPresenter;

/**
 * Class InvoiceLineItemRepositoryEloquent
 * @package namespace App\Repositories;
 */
class InvoiceLineItemRepositoryEloquent extends BaseRepository implements InvoiceLineItemRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return InvoiceLineItem::class;
    }

    /**
     * Specify Presenter class name
     *
     * @return string
     */
    public function presenter()
    {
        return InvoiceLineItemPresenter::class;
    }    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
