<?php

namespace App\Services\Traits;

use App\Models\Account;
use App\Models\AccountType;

trait AccountHelper
{
    private function getAccountTypes(string $type)
    {
        $type = AccountType::with(['children'])->where('name', $type)->first();

        if ($type->children) {
            $types = $type->children->map(function ($child) {
                return $child->id;
            })->toArray();
        }

        return $types;
    }


    /**
     * @param array $typeIDS
     * @param string $id
     * @return mixed
     */
    private function getAccounts(array $typeIDS, string $id)
    {
        return Account::whereIn('account_type_id', $typeIDS)->where('org_id', $id)->get();
    }
}