<?php

namespace App\Repositories;

use App\Models\Plan;
use App\Presenters\PlanPresenter;
use Prettus\Repository\Contracts\CacheableInterface;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Traits\CacheableRepository;

class PlanRepositoryEloquent extends BaseRepository implements PlanRepository, CacheableInterface
{
    use CacheableRepository;
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Plan::class;
    }

    public function presenter()
    {
        return PlanPresenter::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    public function byName(string $name)
    {
        $this->applyCriteria();
        $this->applyScope();

        $result = $this->model->where('name', $name)->first();

        $this->resetModel();
        $this->resetScope();

        return $this->parserResult($result);
    }

    public function byCode(string $code)
    {
        $this->applyCriteria();
        $this->applyScope();

        $result = $this->model->where('paystack_plan_code', $code)->first();

        $this->resetModel();
        $this->resetScope();

        return $this->parserResult($result);
    }
}