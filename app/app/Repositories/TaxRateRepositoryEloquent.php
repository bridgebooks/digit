<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Contracts\CacheableInterface;
use Prettus\Repository\Traits\CacheableRepository;
use App\Repositories\TaxRateRepository;
use App\Models\TaxRate;
use App\Presenters\TaxRatePresenter;

/**
 * Class TaxRateRepositoryEloquent
 * @package namespace App\Repositories;
 */
class TaxRateRepositoryEloquent extends BaseRepository implements TaxRateRepository, CacheableInterface
{
    use CacheableRepository;
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return TaxRate::class;
    }

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function presenter()
    {
        return TaxRatePresenter::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
