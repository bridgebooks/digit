<?php

namespace App\Services\Stats;

use App\Services\Traits\AccountHelper;
use Carbon\Carbon;
use App\Models\Enums\AccountType;

class BillStatsService
{
    use AccountHelper;

    private function transform($accounts, Carbon $start, Carbon $end)
    {
        return $accounts->map(function ($account) use ($start, $end) {
            $balance = $account->getYTDbalance($start, $end);
            $data = [
                'label' => $account->name,
                'value' => $balance
            ];
            return $data;
        })->filter(function($data) {
            return $data['value'] > 0;
        })->values();
    }

    public function getExpenseTotal($accounts, Carbon $start, Carbon $end)
    {
        return $accounts->map(function ($account) use ($start, $end) {
            $balance = $account->getYTDbalance($start, $end);
            return $balance;
        })->sum();
    }

    public function fetch(string $id, Carbon $start, Carbon $end)
    {
        $expenses = $this->getAccountTypesWithChildren(AccountType::EXPENSES);
        $expenseAccounts = $this->getAccounts($expenses, $id);

        return [
          "total" => $this->getExpenseTotal($expenseAccounts, $start, $end),
          "expenses" => $this->transform($expenseAccounts, $start, $end)
        ];
    }
}