<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Contracts\CacheableInterface;
use Prettus\Repository\Traits\CacheableRepository;
use App\Presenters\ContactPresenter;
use App\Models\Contact;

/**
 * Class ContactRepositoryEloquent
 * @package namespace App\Repositories;
 */
class ContactRepositoryEloquent extends BaseRepository implements ContactRepository, CacheableInterface
{
    use CacheableRepository;
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Contact::class;
    }

    /**
     * Specify Presenter class name
     *
     * @return string
     */
    public function presenter()
    {
        return ContactPresenter::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    public function org(string $id, string $type = null)
    {
        $this->applyCriteria();
        $this->applyScope();

        if (!is_null($type)) {
            $results = $this->model->with(['group'])->where('org_id', $id)->where('type', $type)->get();
        } else {
            $results = $this->model->with(['group'])->where('org_id', $id)->get();
        }

        $this->resetModel();
        $this->resetScope();

        return $this->parserResult($results);
    }


    public function search(string $query, string $id = null, $extra = [])
    {
        if ($id) {
            return Contact::search($query)
                ->where('org_id', $id)
                ->paginate(20);
        }

        return Contact::search($query)->paginate(20);
    }

    public function deleteMany(array $ids) {

        $models = $this->model->whereIn('id', $ids)->delete();

        return true;
    }
}
