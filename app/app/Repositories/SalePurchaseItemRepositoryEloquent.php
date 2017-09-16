<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Contracts\CacheableInterface;
use Prettus\Repository\Traits\CacheableRepository;
use App\Repositories\SalePurchaseItemRepository;
use App\Presenters\SalePurchaseItemPresenter;
use App\Models\SalePurchaseItem;

/**
 * Class SaleItemRepositoryEloquent
 * @package namespace App\Repositories;
 */
class SalePurchaseItemRepositoryEloquent extends BaseRepository implements SalePurchaseItemRepository, CacheableInterface
{
    use CacheableRepository;
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return SalePurchaseItem::class;
    }

    public function presenter()
    {
        return SalePurchaseItemPresenter::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
