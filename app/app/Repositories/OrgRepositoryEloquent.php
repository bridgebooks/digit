<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\OrgRepository;
use App\Models\Org;

/**
 * Class RoleRepositoryEloquent
 * @package namespace App\Repositories;
 */
class OrgRepositoryEloquent extends BaseRepository implements OrgRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Org::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
