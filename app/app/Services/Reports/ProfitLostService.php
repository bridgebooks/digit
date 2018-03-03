<?php

namespace App\Services\Reports;


use App\Services\Reports\Contracts\ReportServiceContract;
use App\Services\Traits\AccountHelper;
use Carbon\Carbon;
use App\Models\Enums\AccountType;

class ProfitLostService implements ReportServiceContract
{
    use AccountHelper;

    public function generate(string $id, Carbon $start, Carbon $end)
    {
        $data = [];

        $revenue = $this->getAccountTypes(AccountType::REVENUE);

        return $data;
    }
}