<?php

namespace App\Models;

use App\Models\Enums\PayitemType;
use App\Models\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;

class Payslip extends Model
{
    use Uuids;

    public $incrementing = false;

    protected $table = 'pay_slips';

    protected $fillable = [
        'pay_run_id',
        'employee_id',
        'pay_run_id',
        'wages',
        'deductions',
        'tax',
        'reimbursements',
        'net_pay',
    ];

    public function employee()
    {
        return $this->belongsTo('App\Models\Employee', 'employee_id');
    }

    public function items()
    {
        return $this->hasMany('App\Models\PayslipItem', 'pay_slip_id');
    }

    public function payrun()
    {
        return $this->belongsTo('App\Models\Payrun', 'pay_run_id');
    }

    /**
     * @return int
     */
    private function calculateWages() {
        $wages = 0;

        $wages = $this->items
            ->filter(function ($payslipItem) {
                return $payslipItem->item->pay_item_type === PayitemType::WAGES;
            })
            ->map(function ($item) {
                return $item->amount;
            })
            ->sum();

        $allowances = $this->items
            ->filter(function ($payslipItem) {
                return $payslipItem->item->pay_item_type === PayitemType::ALLOWANCE;
            })
            ->map(function ($item) {
                return $item->amount;
            })
            ->sum();

        return $wages + $allowances;
    }

    /**
     * @return int
     */
    private function calculateDeductions() {
        $amount = 0;

        $amount = $this->items
            ->filter(function ($payslipItem) {
                return $payslipItem->item->pay_item_type === PayitemType::DEDUCTION;
            })
            ->map(function ($item) {
                return $item->amount;
            })
            ->sum();

        return $amount;
    }

    private function calculateReimbursements() {
        $amount = 0;

        $amount = $this->items
            ->filter(function ($payslipItem) {
                return $payslipItem->item->pay_item_type === PayitemType::REIMBURSEMENT;
            })
            ->map(function ($item) {
                return $item->amount;
            })
            ->sum();

        return $amount;
    }

    public function updateTotals()
    {
        $wages = $this->calculateWages();
        $deductions = $this->calculateDeductions();
        $reimbursements = $this->calculateReimbursements();

        $net_pay = $wages + $reimbursements - $deductions;

        $this->wages = $wages;
        $this->deductions = $deductions;
        $this->reimbursements = $reimbursements;
        $this->net_pay = $net_pay;

        $this->save();
    }

}
