<?php

namespace App\Repositories;

use App\Presenters\OrgPresenter;
use Prettus\Repository\Contracts\CacheableInterface;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\OrgRepository;
use App\Models\Org;
use Prettus\Repository\Traits\CacheableRepository;

/**
 * Class RoleRepositoryEloquent
 * @package namespace App\Repositories;
 */
class OrgRepositoryEloquent extends BaseRepository implements OrgRepository, CacheableInterface
{
    use CacheableRepository;
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Org::class;
    }

    public function presenter()
    {
        return OrgPresenter::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    public function orgUsers(string $id)
    {
        $this->applyCriteria();
        $this->applyScope();

        $results = $this->model->find($id)->users()->with(['roles', 'orgRoles'])->get();

        $this->resetModel();
        $this->resetScope();

        return $this->parserResult($results);
    }
}
