<?php

namespace App\Services\Stats;

use App\Models\Enums\AccountType;
use App\Models\Transaction;
use Carbon\Carbon;
use App\Services\Traits\AccountHelper;

class SalesStatsService
{
    use AccountHelper;

    public function getSalesTotal($accounts, Carbon $start, Carbon $end)
    {
        return $accounts->map(function ($account) use ($start, $end) {
            $balance = $account->getYTDbalance($start, $end);
            return $balance;
        })->sum();
    }

    public function fetch(string $id, Carbon $start, Carbon $end)
    {
        $revenue = $this->getAccountTypes(AccountType::REVENUE);
        $revenueAccounts = $this->getAccounts($revenue, $id);
        $accountIDS = $revenueAccounts->map(function ($account) {
            return $account->id;
        })->values();

        $total = $this->getSalesTotal($revenueAccounts, $start, $end);
        $transactions = Transaction::whereIn('account_id', $accountIDS)->whereBetween('created_at', [
            $start->toDateTimeString(),
            $end->toDateTimeString()
        ])->orderBy('created_at', 'asc')->get()
        ->groupBy(function ($transaction) {
            return Carbon::parse($transaction->created_at)->format('d M');
        })
        ->map(function ($date, $key) {
            $value =  $date->map(function ($transaction) {
                return $transaction->credit;
            })->sum();

            return [
                'label' => $key,
                'value' => $value
            ];
        })->values();

        return [
            "total" => $total,
            "transactions" => $transactions
        ];
    }
}