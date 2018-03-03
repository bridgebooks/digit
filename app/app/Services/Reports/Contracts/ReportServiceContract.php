<?php

namespace App\Services\Reports\Contracts;


use Carbon\Carbon;

interface ReportServiceContract
{
    public function generate(string $id, Carbon $start, Carbon $end);
}