<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 04/12/2017
 * Time: 22:10
 */

namespace App\Models\Observers;


use App\Models\Payslip;
use App\Repositories\PayItemRepository;

class PayslipObserver
{
    protected $payitemRepository;

    public function __construct(PayItemRepository $payItemRepository)
    {
        $this->payitemRepository = $payItemRepository;
    }

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

    public function updated(Payslip $payslip)
    {

    }
}