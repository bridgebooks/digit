<?php

namespace App\Repositories;

use Carbon\Carbon;
use App\Models\Enums\EmployeeStatus;
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

        if ($status == 'all')
            $results = $this->model->where('org_id', $id)->get();
        elseif ($status == 'archived')
            $results = $this->model->onlyTrashed()->where('org_id', $id)->get();
        else
            $results = $this->model->where('org_id', $id)->where('status', $status)->get();

        $this->resetModel();
        $this->resetScope();

        return $this->parserResult($results);
    }

    /**
     * @param string $query
     * @param string|null $id
     * @return mixed
     */
    public function search(string $query, string $id = null)
    {
        if ($id) return Employee::search($query)->where('org_id', $id)->paginate(20);

        return Employee::search($query)->paginate(20);
    }

    /**
     * @param array $ids
     * @return bool
     */
    public function archiveMany(array $ids) {

        $this->model->whereIn('id', $ids)->delete();

        return true;
    }

    /**
     * @param array $ids
     * @return bool
     */
    public function deleteMany(array $ids) {

        $this->model->whereIn('id', $ids)->forceDelete();

        return true;
    }

    /**
     * @param array $ids
     * @return bool
     */
    public function restoreMany(array $ids) {

        $models = $this->model->onlyTrashed()->whereIn('id', $ids)->restore();

        return true;
    }

    /**
     * @param array $ids
     * @return bool
     */
    public function terminateMany(array $ids) {

        $this->model->whereIn('id', $ids)
            ->update([
                'termination_date' => Carbon::now()->toDateString(),
                'status' => EmployeeStatus::TERMINATED
            ]);

        return true;
    }
}
