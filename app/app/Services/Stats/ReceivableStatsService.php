<?php

namespace App\Services\Stats;

use App\Models\Enums\InvoiceStatus;
use App\Services\Traits\InvoiceHelper;
use Carbon\Carbon;

class ReceivableStatsService
{
    use InvoiceHelper;

    public function fetch(string $id, Carbon $start, Carbon $end)
    {
        $invoices = $this->getAllInvoicesBetween($id, 'acc_rec', $start, $end);
        $invoices = $invoices->filter(function ($invoice) {
            return in_array($invoice->status, [InvoiceStatus::AUTHORIZED, InvoiceStatus::SENT]);
        })->groupBy(function ($invoice) {
            return Carbon::parse($invoice->raised_at)->format('d M'); // grouping by date
        })->map(function ($date, $key) {
           $value =  $date->map(function ($invoice) {
              return $invoice->total;
           })->sum();

           return [
               'label' => $key,
               'value' => $value
           ];
        })->values();

        return $invoices;
    }
}