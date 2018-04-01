<?php

namespace App\Services\Stats;

use App\Models\Enums\InvoiceStatus;
use App\Services\Traits\InvoiceHelper;
use Carbon\Carbon;

class InvoiceStatsService
{
    use InvoiceHelper;

    public function fetch(string $id, Carbon $start, Carbon $end)
    {
        $invoices = $this->getAllInvoicesBetween($id, 'acc_rec', $start, $end);

        $paid = $invoices->filter(function ($invoice) {
            return in_array($invoice->status, [ InvoiceStatus::PAID ]);
        })->map(function ($invoice) {
            return $invoice->total;
        })->sum();

        $overdue = $invoices->filter(function ($invoice) {
            $due_at = new Carbon($invoice->due_at);
            $now = new Carbon('now');

            return !in_array($invoice->status, [InvoiceStatus::PAID, InvoiceStatus::VOIDED])
                && $now->diffInDays($due_at) > 0;

        })->map(function ($invoice) {
            return $invoice->total;
        })->sum();

        $unpaid = $invoices->filter(function ($invoice) {
            return !in_array($invoice->status, [ InvoiceStatus::PAID, InvoiceStatus::VOIDED ]);
        })->map(function ($invoice) {
            return $invoice->total;
        })->sum();

        return [
          [
              "label" => "Unpaid",
              "value" => $unpaid
          ],
            [
                "label" => "Overdue",
                "value" => $overdue
            ],
            [
                "label" => "Paid",
                "value" => $paid
            ]
        ];
    }
}