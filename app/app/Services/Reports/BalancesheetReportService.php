<?php

namespace App\Services\Reports;
use App\Models\Enums\AccountType;

use App\Models\Org;
use App\Services\Reports\Contracts\ReportServiceContract;
use App\Services\Traits\AccountHelper;
use Carbon\Carbon;

class BalancesheetReportService implements ReportServiceContract
{
    use AccountHelper;

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

        $assets = $this->getAccountTypesWithChildren(AccountType::ASSETS);
        $liablities = $this->getAccountTypesWithChildren(AccountType::LIABILITIES);
        $equity = $this->getAccountTypesWithChildren(AccountType::EQUITY);

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

        $extras = [
            "org" => Org::find($id),
            "balance_date" => $end->format("d F Y")
        ];
        $filename = sprintf('%s-%s(%s)', $extras['org']->name,'Balance-Sheet', $extras['balance_date']);

        return $this->generatePDF($data, $filename, 'reports.balance-sheet', $extras);
    }
}