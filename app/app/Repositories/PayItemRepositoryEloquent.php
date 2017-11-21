<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\PayItemRepository;
use App\Models\PayItem;
use App\Validators\PayItemValidator;

/**
 * Class PayItemRepositoryEloquent
 * @package namespace App\Repositories;
 */
class PayItemRepositoryEloquent extends BaseRepository implements PayItemRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return PayItem::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
