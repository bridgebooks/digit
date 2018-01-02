<?php

namespace App\Repositories;

use App\Models\OrgPayrunSetting;
use App\Presenters\OrgPayrunSettingPresenter;
use Prettus\Repository\Contracts\CacheableInterface;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Traits\CacheableRepository;

class OrgPayrunSettingRepositoryEloquent extends BaseRepository implements OrgPayrunSettingRepository, CacheableInterface
{
    use CacheableRepository;

    protected $defaultValues = [
        'wages_account' => null,
        'employee_tax_account' => null,
        'basic_wage_item' => null,
        'housing_allowance_item' => null,
        'transport_allowance_item' => null,
    ];
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return OrgPayrunSetting::class;
    }

    /**
     * Specify Presenter class name
     *
     * @return string
     */
    public function presenter()
    {
        return OrgPayrunSettingPresenter::class;
    }

    public function get(string $id)
    {
        $this->applyScope();

        $temporarySkipPresenter = $this->skipPresenter;

        $this->skipPresenter(true);

        $check = $this->model->where('org_id', $id)->first();

        if (!$check) {
            $model = $this->model->create(['org_id' => $id, 'values' => $this->defaultValues ]);
        } else {
            $model = $check;

        }

        $this->skipPresenter($temporarySkipPresenter);
        $this->resetModel();

        return $this->parserResult($model);
    }
    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}