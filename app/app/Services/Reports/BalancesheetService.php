<?php

namespace App\Services\Reports;
use App\Models\Enums\AccountType;

use App\Services\Traits\AccountHelper;
use Carbon\Carbon;

class BalancesheetService
{
    use AccountHelper;

    /**
     * @param string $id
     * @param Carbon $start
     * @param Carbon $end
     * @return array
     */
    public function generate(string $id, Carbon $start, Carbon $end)
    {
        $data = [];

        $assets = $this->getAccountTypes(AccountType::ASSETS);
        $liablities = $this->getAccountTypes(AccountType::LIABILITIES);
        $equity = $this->getAccountTypes(AccountType::EQUITY);

        $assetsAccounts = $this->getAccounts($assets, $id);
        $liablityAccounts = $this->getAccounts($liablities, $id);
        $equityAccounts = $this->getAccounts($equity, $id);

        $data['assets'] = $assetsAccounts->map(function ($account) use ($start, $end) {
            $balance = $account->getYTDbalance($start, $end);
            $data = [
              'id' => $account->id,
                'code' => $account->code,
                'name' => $account->name,
                'balance' => $balance
            ];
            return $data;
        });

        $data['liabilities'] = $liablityAccounts->map(function ($account) use ($start, $end) {
            $balance = $account->getYTDbalance($start, $end);
            $data = [
                'id' => $account->id,
                'code' => $account->code,
                'name' => $account->name,
                'balance' => $balance
            ];
            return $data;
        });

        $data['equity'] = $equityAccounts->map(function ($account) use ($start, $end) {
            $balance = $account->getYTDbalance($start, $end);
            $data = [
                'id' => $account->id,
                'code' => $account->code,
                'name' => $account->name,
                'balance' => $balance
            ];
            return $data;
        });


        return $data;
    }
}