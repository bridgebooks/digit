<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Contracts\CacheableInterface;
use Prettus\Repository\Traits\CacheableRepository;
use App\Presenters\ContactGroupPresenter;
use App\Models\ContactGroup;
use App\Models\Contact;

/**
 * Class RoleRepositoryEloquent
 * @package namespace App\Repositories;
 */
class ContactGroupRepositoryEloquent extends BaseRepository implements ContactGroupRepository, CacheableInterface
{
    use CacheableRepository;
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return ContactGroup::class;
    }

    /**
     * Specify Presenter class name
     *
     * @return string
     */
    public function presenter()
    {
        return ContactGroupPresenter::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    public function toGroup(string $id, Contact...$contacts)
    {
        $model = $this->model->find($id);

        if (!$model) return false;

        if ($model->contacts()->attach($contacts)) return true;
    }
}
