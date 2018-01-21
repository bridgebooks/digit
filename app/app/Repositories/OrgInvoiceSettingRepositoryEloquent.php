<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Contracts\CacheableInterface;
use Prettus\Repository\Traits\CacheableRepository;
use App\Repositories\OrgInvoiceSettingRepository;
use App\Models\OrgInvoiceSetting;
use App\Presenters\OrgInvoiceSettingPresenter;
/**
 * Class OrgInvoiceSettingRepositoryEloquent
 * @package namespace App\Repositories;
 */
class OrgInvoiceSettingRepositoryEloquent extends BaseRepository implements OrgInvoiceSettingRepository, CacheableInterface
{
    use CacheableRepository;
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return OrgInvoiceSetting::class;
    }

    /**
     * Specify Presenter class name
     *
     * @return string
     */
    public function presenter()
    {
        return OrgInvoiceSettingPresenter::class;
    }

    public function byOrgID(string $id)
    {
        $this->applyScope();

        if (!is_null($this->validator)) {
            $this->validator->with($attributes)->passesOrFail(ValidatorInterface::RULE_UPDATE);
        }

        $temporarySkipPresenter = $this->skipPresenter;

        $this->skipPresenter(true);

        $check = $this->model->where('org_id', $id)->first();
        if (!$check) {
            $model = $this->model->create(['org_id' => $id ]);
        }
        $model = $check;

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
