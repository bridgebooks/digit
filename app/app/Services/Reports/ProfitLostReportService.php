<?php

namespace App\Services\Reports;


use App\Models\Org;
use App\Services\Reports\Contracts\ReportServiceContract;
use App\Services\Traits\AccountHelper;
use Carbon\Carbon;
use App\Models\Enums\AccountType;

class ProfitLostReportService implements ReportServiceContract
{
    use AccountHelper;

    public function generate(string $id, Carbon $start, Carbon $end, bool $pdf = false)
    {
        $data = [];

        $revenue = $this->getAccountTypes(AccountType::REVENUE);
        $costs = $this->getAccountTypes(AccountType::DIRECT_COST);
        $expenses = $this->getAccountTypesWithChildren(AccountType::EXPENSES);

        $revenueAccounts = $this->getAccounts($revenue, $id);
        $purchaseAccounts = $this->getAccounts($costs, $id);
        $expenseAccounts = $this->getAccounts($expenses, $id);

        $data['income'] = $this->transform($revenueAccounts, $start, $end);
        $data['income_total'] = $this->getTotal($data['income']);

        $data['purchases'] = $this->transform($purchaseAccounts, $start, $end);
        $data['purchase_total'] = $this->getTotal($data['purchases']);

        $data['expenses'] = $this->transform($expenseAccounts, $start, $end);
        $data['expense_total'] = $this->getTotal($data['expenses']);
        $data['gross_profit'] =  $data['income_total'] - $data['purchase_total'];
        $data['net_profit'] = $data['gross_profit'] - $data['expense_total'];

        if (!$pdf) return $data;

        $extras = [
            "org" => Org::find($id),
            "start_date" => $start->format("d F Y"),
            "end_date" => $end->format("d F Y")
        ];
        $filename = sprintf('%s-%s(%s)', $extras['org']->name,'Profit-Loss', $extras['end_date']);

        return $this->generatePDF($data, $filename, 'reports.profit-loss', $extras);
    }
}