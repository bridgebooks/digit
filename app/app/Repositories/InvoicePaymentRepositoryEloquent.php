<?php

namespace App\Repositories;

use App\Presenters\InvoicePaymentPresenter;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Models\InvoicePayment;

/**
 * Class InvoicePaymentRepositoryEloquent
 * @package namespace App\Repositories;
 */
class InvoicePaymentRepositoryEloquent extends BaseRepository implements InvoicePaymentRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return InvoicePayment::class;
    }

    /**
     * Specify Presenter class name
     *
     * @return string
     */
    public function presenter()
    {
        return InvoicePaymentPresenter::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
