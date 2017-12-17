<?php

namespace App\Repositories;

use App\Presenters\PayslipItemPresenter;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Models\PayslipItem;

/**
 * Class PayslipItemRepositoryEloquent
 * @package namespace App\Repositories;
 */
class PayslipItemRepositoryEloquent extends BaseRepository implements PayslipItemRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return PayslipItem::class;
    }

    /**
     * Specify presenter class name
     *
     * @return string
     */
    public function presenter()
    {
        return PayslipItemPresenter::class;
    }

    /**
     * Fetch payslip items
     * @param string $id
     * @return mixed
     */
    public function payslip(string $id)
    {
        $this->applyCriteria();
        $this->applyScope();

        $results = $this->model->where('pay_slip_id', $id)->get();

        $this->resetModel();
        $this->resetScope();

        return $this->parserResult($results);
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
