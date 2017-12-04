<?php

namespace App\Models;

use App\Models\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;

class PayslipItem extends Model
{
    use Uuids;

    protected $table = 'pay_slip_items';

    public $incrementing = false;

    protected $fillable = [
        'pay_slip_id',
        'pay_item_id',
        'amount'
    ];

    public function payslip()
    {
        return $this->belongsTo('App\Models\Payslip', 'pay_slip_id');
    }

    public  function payitem()
    {
        return $this->belongsTo('App\Models\PayItem', 'pay_item_id');
    }

}
