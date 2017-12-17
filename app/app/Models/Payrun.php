<?php

namespace App\Models;

use App\Models\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Payrun extends Model
{
    use Searchable, Uuids;

    public $incrementing = false;

    protected $table = 'pay_runs';

    protected $fillable = [
        'org_id',
        'user_id',
        'start_date',
        'end_date',
        'payment_date',
        'wages',
        'deductions',
        'tax',
        'reimbursements',
        'net_pay',
        'notes',
        'status'
    ];

    protected $dates = ['start_date', 'end_date', 'payment_date'];

    public function payslips()
    {
        return $this->hasMany('App\Models\Payslip', 'pay_run_id');
    }

    public function creator()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function org()
    {
        return $this->belongsTo('App\Models\Org');
    }

    private function wages()
    {
       $amount = 0;

       foreach($this->payslips as $slip) {
           $amount = $amount + $slip->wages;
       }

       return $amount;
    }

    private function deductions()
    {
        $amount = 0;

        foreach($this->payslips as $slip) {
            $amount = $amount + $slip->deductions;
        }

        return $amount;
    }

    private function reimbursements()
    {
        $amount = 0;

        foreach($this->payslips as $slip) {
            $amount = $amount + $slip->reimbursements;
        }

        return $amount;
    }

    private function tax()
    {
        $amount = 0;

        foreach($this->payslips as $slip) {
            $amount = $amount + $slip->tax;
        }

        return $amount;
    }

    public function updateTotals()
    {
        $wages = $this->wages();
        $deductions = $this->deductions();
        $reimbursements = $this->reimbursements();
        $taxes = $this->tax();

        $net_pay = $wages + $reimbursements - $deductions - $taxes;

        $this->wages = $wages;
        $this->deductions = $deductions;
        $this->reimbursements = $reimbursements;
        $this->tax = $taxes;
        $this->net_pay = $net_pay;

        $this->save();
    }
}
