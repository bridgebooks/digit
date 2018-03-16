<?php

namespace App\Services\Traits;

use App\Models\Account;
use App\Models\AccountType;
use Carbon\Carbon;
use View;
use PDF;

trait AccountHelper
{
    private function getAccountTypesWithChildren(string $type)
    {
        $type = AccountType::with(['children'])->where('name', $type)->first();

        if (isset($type->children)) {
            $types = $type->children->map(function ($child) {
                return $child->id;
            })->toArray();
        }

        return $types;
    }

    private function getAccountTypes(string $type)
    {
        $types = AccountType::where('name', $type)->get();

        $types = $types->map(function ($child) {
            return $child->id;
        })->toArray();

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

    private function transform($accounts, Carbon $start, Carbon $end)
    {
        return $accounts->map(function ($account) use ($start, $end) {
            $balance = $account->getYTDbalance($start, $end);
            $data = [
                'id' => $account->id,
                'code' => $account->code,
                'name' => $account->name,
                'balance' => $balance
            ];
            return $data;
        })->toArray();
    }

    private function getTotal(array $accounts)
    {
        $balances = array_map(function ($account) {
            return $account['balance'];
        }, $accounts);

        return array_reduce($balances, function ($carry, $item) {
            $carry += $item;
            return $carry;
        });
    }


    /**
     * @param array $data
     * @param string $filename
     * @param string $template
     * @param array $extras
     * @return mixed
     */
    private function generatePDF(array $data, string $filename, string $template, array $extras = [])
    {
        $html = View::make($template, $data)
            ->with($extras)
            ->render();
        $html = preg_replace('/>\s+</', '><', $html);

        $pdf = PDF::loadHtml($html);
        $pdf->setPaper('a4', 'landscape');
        $filename = sprintf('%s.pdf', $filename);
        return $pdf->download($filename);
    }
}