<?php

namespace App\Repositories;

use App\Presenters\PayrunPresenter;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Models\Payslip;
use App\Models\Payrun;

/**
 * Class PayrunRepositoryEloquent
 * @package namespace App\Repositories;
 */
class PayrunRepositoryEloquent extends BaseRepository implements PayrunRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Payrun::class;
    }

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function presenter()
    {
        return PayrunPresenter::class;
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
        else
            $results = $this->model->where('org_id', $id)->where('status', $status)->get();

        $this->resetModel();
        $this->resetScope();

        return $this->parserResult($results);
    }

    public function addPayslips(array $slips, string $id)
    {
        $model = $this->model->find($id);

        $model->payslips()->createMany($slips);
    }
}
