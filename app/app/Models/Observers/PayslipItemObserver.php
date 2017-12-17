<?php

namespace App\Models\Observers;

use App\Models\PayslipItem;

class PayslipItemObserver
{
    public function updated(PayslipItem $payslipItem)
    {
        $payslip = $payslipItem->payslip;

        $payslip->updateTotals();
    }
}