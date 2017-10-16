<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\OrgRoleRepository;
use App\Presenters\OrgRolePresenter;
use App\Models\OrgRole;

/**
 * Class OrgRoleRepositoryEloquent
 * @package namespace App\Repositories;
 */
class OrgRoleRepositoryEloquent extends BaseRepository implements OrgRoleRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return OrgRole::class;
    }

    /**
     * Specify Presenter class name
     *
     * @return string
     */
    public function presenter()
    {
        return OrgRolePresenter::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
