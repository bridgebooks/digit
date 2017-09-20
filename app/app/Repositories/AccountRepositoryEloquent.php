<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Contracts\CacheableInterface;
use Prettus\Repository\Traits\CacheableRepository;
use App\Repositories\AccountRepository;
use App\Models\Account;
use App\Presenters\AccountPresenter;
/**
 * Class AccountRepositoryEloquent
 * @package namespace App\Repositories;
 */
class AccountRepositoryEloquent extends BaseRepository implements AccountRepository, CacheableInterface
{
    use CacheableRepository;
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Account::class;
    }

    /**
     * Specify Presenter class name
     *
     * @return string
     */
    public function presenter()
    {
        return AccountPresenter::class;
    }    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    public function deleteMany(array $ids) {

        $models = $this->model->whereIn('id', $ids)->where('is_system', false)->delete();

        return true;
    }
}
