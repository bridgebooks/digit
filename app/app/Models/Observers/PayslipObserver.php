<?php

namespace App\Models\Observers;

use App\Models\Payslip;
use App\Repositories\PayItemRepository;
use App\Jobs\GeneratePayslipPDF;

class PayslipObserver
{
    protected $payitemRepository;

    public function __construct(PayItemRepository $payItemRepository)
    {
        $this->payitemRepository = $payItemRepository;
    }

    public function creating(Payslip $payslip)
    {
        $payslip->reference = 'PR-'. time() . rand(10*45, 100*98);
    }
    /**
     * @param Payslip $payslip
     */
    public function created(Payslip $payslip)
    {
        $org = $payslip->payrun->org;
        $defaultPayitems = $this->payitemRepository->skipPresenter()->getOrgDefault($org->id);

        if (count($defaultPayitems) > 0) {
            $payslipItems = [];

            foreach ($defaultPayitems as $payitem) {
                $payslipItems[] = [
                    'pay_slip_id' => $payslip->id,
                    'pay_item_id'=> $payitem->id,
                    'amount' => $payitem->default_amount
                ];
           }

           $payslip->items()->createMany($payslipItems);
        }
    }

    /**
     * @param Payslip $payslip
     */
    public function updated(Payslip $payslip)
    {
        $payrun = $payslip->payrun();
        if ( is_null($payslip->pdf_url) ) $payrun->updateTotals();
    }
}