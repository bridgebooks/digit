<?php

namespace App\Repositories;

use App\Presenters\PayitemPresenter;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Models\PayItem;

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
     * Specify Presenter class name
     *
     * @return string
     */
    public function presenter()
    {
        return PayitemPresenter::class;
    }

    public function org(string $id, bool $archived = false)
    {
        $this->applyCriteria();
        $this->applyScope();

        if (!$archived)
            $results = $this->model->where('org_id', $id)->get();
        else
            $results = $this->model->onlyTrashed()->where('org_id', $id)->get();

        $this->resetModel();
        $this->resetScope();

        return $this->parserResult($results);
    }

    public function getOrgDefault(string $id)
    {
        $this->applyCriteria();
        $this->applyScope();

        $results = $this->model->where('org_id', $id)->where('mark_default', 1)->get();

        $this->resetModel();
        $this->resetScope();

        return $this->parserResult($results);
    }

    public function forceDelete(string $id)
    {
        $model = $this->model->onlyTrashed()->find($id);

        return $model->forceDelete();
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
