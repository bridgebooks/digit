<?php

namespace App\Models\Observers;

use App\Events\PayrunApproved;
use App\Models\Enums\PayrunStatus;
use App\Models\Payrun;

class PayrunObserver
{
    public function updated(Payrun $payrun)
    {
        if ($payrun->status == PayrunStatus::APPROVED) {
        }
    }
}