<?php

namespace App\Models\Observers;


use App\Events\InvoicePaymentSuccess;
use App\Events\PayslipPaid;
use App\Models\Enums\InvoicePaymentStatus;
use App\Models\InvoicePayment;

class InvoicePaymentObserver
{
    public function created(InvoicePayment $payment)
    {
    }
}