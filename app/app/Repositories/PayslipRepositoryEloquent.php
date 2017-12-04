<?php

namespace App\Repositories;

use App\Presenters\PayslipPresenter;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Models\Payslip;

/**
 * Class PayslipRepositoryEloquent
 * @package namespace App\Repositories;
 */
class PayslipRepositoryEloquent extends BaseRepository implements PayslipRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Payslip::class;
    }

    /**
     * Specify Presenter class name
     *
     * @return string
     */
    public function presenter()
    {
        return PayslipPresenter::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
