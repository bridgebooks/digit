<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Contracts\CacheableInterface;
use Prettus\Repository\Traits\CacheableRepository;
use App\Repositories\OrgAccountSettingRepository;
use App\Models\OrgAccountSetting;
use App\Models\Account;
use App\Presenters\OrgAccountSettingPresenter;


/**
 * Class OrgAccountSettingRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class OrgAccountSettingRepositoryEloquent extends BaseRepository implements OrgAccountSettingRepository, CacheableInterface
{
    use CacheableRepository;

    protected $defaultValues = [
        'accounts_receivable' => null,
        'accounts_payable' => null,
        'sales_tax' => null,
        'financial_year' => [
            "day" => 31,
            "month" => 12
        ]
    ];

    private function getAccountsReceivable(string $id)
    {
        $account = Account::byName('Accounts Receivable', $id)->where('is_system', 1)->first();
        return $account->id ?? null;
    }

    private function getAccountsPayable(string $id) 
    {
        $account = Account::byName('Accounts Payable', $id)->where('is_system', 1)->first();
        return $account->id ?? null;
    }

    private function getSalesTax(string $id) 
    {
        $account = Account::byName('Sales Tax', $id)->where('is_system', 1)->first();
        return $account->id ?? null;
    }

    private function getWages(string $id)
    {
        $account = Account::byName('Wages and Salaries', $id)->where('is_system', 1)->first();
        return $account->id ?? null;
    }

    /**
     * Set default account settings values
     * @param string $id
     * ID of the Org Model
     * @return void
     */
    private function setDefaultValues(string $id)
    {
        $this->defaultValues['accounts_receivable'] = $this->getAccountsReceivable($id);
        $this->defaultValues['accounts_payable'] = $this->getAccountsPayable($id);
        $this->defaultValues['sales_tax'] = $this->getSalesTax($id);
    }

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return OrgAccountSetting::class;
    }

     /**
     * Specify Presenter class name
     *
     * @return string
     */
    public function presenter()
    {
        return OrgAccountSettingPresenter::class;
    }

    public function byOrgID(string $id)
    {
        $this->applyScope();

        $temporarySkipPresenter = $this->skipPresenter;

        $this->skipPresenter(true);

        $check = $this->model->where('org_id', $id)->first();

        if (!$check) {
            $this->setDefaultValues($id);
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
