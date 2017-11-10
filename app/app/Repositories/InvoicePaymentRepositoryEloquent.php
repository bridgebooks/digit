<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\InvoicePaymentRepository;
use App\Models\InvoicePayment;
use App\Validators\InvoicePaymentValidator;

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
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
