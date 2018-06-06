<?php

namespace App\Services\Stats;

use Carbon\Carbon;
use App\Models\Enums\AccountType;
use App\Services\Traits\AccountHelper;

class ProfileLossStatService
{
    use AccountHelper;

    public function fetch(string $id, Carbon $start, Carbon $end)
    {
        $revenue = $this->getAccountTypes(AccountType::REVENUE);
        $costs = $this->getAccountTypes(AccountType::DIRECT_COST);
        $expenses = $this->getAccountTypesWithChildren(AccountType::EXPENSES);

        $revenueAccounts = $this->getAccounts($revenue, $id);
        $purchaseAccounts = $this->getAccounts($costs, $id);
        $expenseAccounts = $this->getAccounts($expenses, $id);

        $income = $this->transform($revenueAccounts, $start, $end);
        $incomeTotal = $this->getTotal($income);

        $purchases = $this->transform($purchaseAccounts, $start, $end);
        $purchaseTotal = $this->getTotal($purchases);

        $expenses = $this->transform($expenseAccounts, $start, $end);
        $expenseTotal = $this->getTotal($expenses);
        $grossProfit = $incomeTotal - $purchaseTotal;
        $netProfit = $grossProfit - $expenseTotal;

        return [
          "net_profit" => $netProfit,
          "income" => $incomeTotal,
          "expenses" => $expenseTotal
        ];
    }
}