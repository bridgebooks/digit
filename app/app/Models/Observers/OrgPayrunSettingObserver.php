<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 02/01/2018
 * Time: 06:24
 */

namespace App\Models\Observers;

use App\Models\Enums\PayitemType;
use App\Models\OrgPayrunSetting;
use App\Models\PayItem;
use App\Models\Account;
use App\Traits\UserRequest;

class OrgPayrunSettingObserver
{
    use UserRequest;
    /**
     * Listen to the Model created event.
     *
     * @param  User  $user
     * @return void
     */
    public function created(OrgPayrunSetting $setting)
    {
        // create tax payitem
        $payitem = new PayItem();

        // get employee tax account
        $account = Account::where('org_id', $setting->org_id)->where('name', 'Employee Tax Payable')->first();

        $payitem->org_id = $setting->org_id;
        $payitem->user_id = $this->requestUser()->id;
        $payitem->pay_item_type = PayitemType::TAX;
        $payitem->account_id = $account ? $account->id : $setting->values->employee_tax_account;
        $payitem->name = "Tax";
        $payitem->is_system = true;
        $payitem->description = "Employee income tax";
        $payitem->mark_default = 1;

        $payitem->save();
    }}