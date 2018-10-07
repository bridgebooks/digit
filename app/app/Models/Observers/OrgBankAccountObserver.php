<?php

namespace App\Models\Observers;


use App\Events\DefaultOrgBankAccountCreated;
use App\Models\OrgBankAccount;

class OrgBankAccountObserver
{
    public function created(OrgBankAccount $account) {

        if ((bool) $account->is_default) {
            $accounts = OrgBankAccount::where('id', '!=', $account->id)
                ->where('org_id', '=', $account->org_id)
                ->get();

            if (count($accounts) > 0) {
                $accounts
                    ->each(function ($account) {
                        $account->is_default = false;
                        $account->save();
                    });
            }

            event(new DefaultOrgBankAccountCreated($account));
        }
    }
}