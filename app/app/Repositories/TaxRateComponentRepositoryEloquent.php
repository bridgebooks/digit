<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\TaxRateComponentRepository;
use App\Models\TaxRateComponent;
use App\Presenters\TaxRateComponentPresenter;

/**
 * Class TaxRateComponentRepositoryEloquent
 * @package namespace App\Repositories;
 */
class TaxRateComponentRepositoryEloquent extends BaseRepository implements TaxRateComponentRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return TaxRateComponent::class;
    }

    /**
     * Specify Presenter class name
     *
     * @return string
     */
    public function model()
    {
        return TaxRateComponentPresenter::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
