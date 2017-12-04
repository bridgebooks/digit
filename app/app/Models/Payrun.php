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
}
