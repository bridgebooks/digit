<?php

namespace App\Services\Reports;
use App\Models\Enums\AccountType;

use App\Models\Org;
use App\Services\Reports\Contracts\ReportServiceContract;
use App\Services\Traits\AccountHelper;
use Carbon\Carbon;
use View;
use PDF;

class BalancesheetService implements ReportServiceContract
{
    use AccountHelper;

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

    private function generatePDF(array $data, Carbon $date, string $id)
    {
        $org = Org::find($id);
        $html = View::make('reports.balance-sheet', $data)
            ->with([
                'org' => $org,
                'balance_date' => $date->format("d F Y")
            ])
            ->render();
        $html = preg_replace('/>\s+</', '><', $html);

        $pdf = PDF::loadHtml($html);
        $pdf->setPaper('a4', 'portrait');
        $filename = sprintf('%s-%s-%s.pdf', $org->name,'Balance Sheet', $date->format("d-m-y"));
        return $pdf->download($filename);
    }

    /**
     * @param string $id
     * @param Carbon $start
     * @param Carbon $end
     * @param bool $pdf
     * @return array
     */
    public function generate(string $id, Carbon $start, Carbon $end, bool $pdf = false)
    {
        $data = [];

        $assets = $this->getAccountTypes(AccountType::ASSETS);
        $liablities = $this->getAccountTypes(AccountType::LIABILITIES);
        $equity = $this->getAccountTypes(AccountType::EQUITY);

        $assetsAccounts = $this->getAccounts($assets, $id);
        $liablityAccounts = $this->getAccounts($liablities, $id);
        $equityAccounts = $this->getAccounts($equity, $id);

        $data['assets'] = $this->transform($assetsAccounts, $start, $end);
        $data['assets_total'] = $this->getTotal($data['assets']);

        $data['liabilities'] = $this->transform($liablityAccounts, $start, $end);
        $data['liabilities_total'] = $this->getTotal($data['liabilities']);

        $data['equity'] = $this->transform($equityAccounts, $start, $end);
        $data['equity_total'] = $this->getTotal($data['equity']) ?? 0;


        if (!$pdf) return $data;

        return $this->generatePDF($data, $end, $id);
    }
}