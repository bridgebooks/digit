<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Contracts\CacheableInterface;
use Prettus\Repository\Traits\CacheableRepository;
use App\Repositories\OrgBankAccountRepository;
use App\Models\OrgBankAccount;
use App\Presenters\OrgBankAccountPresenter;

/**
 * Class OrgBankAccountRepositoryEloquent
 * @package namespace App\Repositories;
 */
class OrgBankAccountRepositoryEloquent extends BaseRepository implements OrgBankAccountRepository, CacheableInterface
{
    use CacheableRepository;
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return OrgBankAccount::class;
    }

    /**
     * Specify Presenter class name
     * @return string
     */
    public function presenter()
    {
        return OrgBankAccountPresenter::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
