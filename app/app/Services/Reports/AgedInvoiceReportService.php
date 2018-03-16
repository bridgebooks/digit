<?php

namespace App\Services\Reports;


use App\Models\Org;
use App\Services\Traits\InvoiceHelper;
use App\Services\Traits\AccountHelper;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class AgedInvoiceReportService
{
    use InvoiceHelper, AccountHelper;

    private function getCurrentMonthInvoices(string $id, string $type, Carbon $date)
    {
        $startDate = $date->copy()->startOfMonth();
        $endDate = $startDate->copy()->endOfMonth();

        return $this->getInvoices($id, $type, $startDate, $endDate);
    }

    private function getInvoicesWithinPeriod(string $id, string $type, Carbon $date, string $period = '30')
    {
        switch ($period) {
            case '30':
                $subtract = 1;
                break;
            case '60':
                $subtract = 2;
                break;
            case '90':
                $subtract = 3;
                break;
        }

        $startDate = $date->copy()->startOfMonth()->subMonth($subtract);
        $endDate = $startDate->copy()->endOfMonth();
    
        return $this->getInvoices($id, $type, $startDate, $endDate);
    }
    
    private function getRatio(float $value, float $total)
    {   
        if ($total > 0)
            $ratio = ($value / $total) * 100;
        else
            $ratio = 0;

        return number_format($ratio, 2);
    }

    public function generate(string $id, string $type = 'acc_rec', Carbon $start, bool $pdf = false)
    {
        $contacts = $this->getContacts($id, $type)
            ->map(function ($contact) use ($type, $start) {
                $data = [
                    'contact_id' => $contact->id,
                    'name' => $contact->name,
                    'current' => $this->getCurrentMonthInvoices($contact->id, $type, $start),
                    'thirty_day' => $this->getInvoicesWithinPeriod($contact->id, $type, $start),
                    'sixty_day' => $this->getInvoicesWithinPeriod($contact->id, $type, $start, '60'),
                    'ninety_day' => $this->getInvoicesWithinPeriod($contact->id, $type, $start, '90'),
                ];
                $data['total'] = $data['current'] + $data['thirty_day'] + $data['sixty_day'] + $data['ninety_day'];
                return $data;
            })->toArray();

        $_contacts = new Collection($contacts);

        $currentTotal = $_contacts->map(function ($item) {
            return $item['current'];
        })->sum();

        $thirtyDayTotal = $_contacts->map(function ($item) {
            return $item['thirty_day'];
        })->sum();

        $sixtyDayTotal = $_contacts->map(function ($item) {
            return $item['sixty_day'];
        })->sum();

        $ninetyDayTotal = $_contacts->map(function ($item) {
            return $item['ninety_day'];
        })->sum();

        $total = $_contacts->map(function ($item) {
            return $item["total"];
        })->sum();

        $data = [
            "contacts" => $contacts,
            "current_total" => $currentTotal,
            "current_ratio" => $this->getRatio($currentTotal, $total),
            "thirty_day_total" => $thirtyDayTotal,
            "thirty_day_ratio" => $this->getRatio($thirtyDayTotal, $total),
            "sixty_day_total" => $sixtyDayTotal,
            "sixty_day_ratio" => $this->getRatio($sixtyDayTotal, $total),
            "ninety_day_total" => $ninetyDayTotal,
            "ninety_day_ratio" => $this->getRatio($ninetyDayTotal, $total),
            "total" => $total
        ];

        if (!$pdf) return $data;

        $name = $type == 'acc_rec' ? 'Aged Receiveables' : 'Aged Payables';
        $extras = [
            "title" => $name,
            "org" => Org::find($id),
            "balance_date" => $start->format("d F Y")
        ];
        $filename = sprintf('%s-%s(%s)', $extras['org']->name, $name, $extras['balance_date']);

        return $this->generatePDF($data, $filename, 'reports.aged-invoices', $extras);
    }
}