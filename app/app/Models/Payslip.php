<?php

namespace App\Models;

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

}
