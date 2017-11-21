<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Contracts\CacheableInterface;
use Prettus\Repository\Traits\CacheableRepository;
use App\Repositories\EmployeeRepository;
use App\Models\Employee;
use App\Presenters\EmployeePresenter;
/**
 * Class AccountRepositoryEloquent
 * @package namespace App\Repositories;
 */
class EmployeeRepositoryEloquent extends BaseRepository implements EmployeeRepository, CacheableInterface
{
    use CacheableRepository;
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Employee::class;
    }

    /**
     * Specify Presenter class name
     *
     * @return string
     */
    public function presenter()
    {
        return EmployeePresenter::class;
    }    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    /**
     * @param string $id
     * @param string|null $status
     * @return mixed
     */
    public function org(string $id, string $status = null)
    {
        $this->applyCriteria();
        $this->applyScope();

        if (!is_null($status)) {
            $results = $this->model->with(['bank'])->where('org_id', $id)->where('status', $status)->get();
        } else {
            $results = $this->model->with(['bank'])->where('org_id', $id)->get();
        }

        $this->resetModel();
        $this->resetScope();

        return $this->parserResult($results);
    }

    /**
     * @param array $ids
     * @return bool
     */
    public function deleteMany(array $ids) {

        $models = $this->model->whereIn('id', $ids)->delete();

        return true;
    }
}
