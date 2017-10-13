<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Traits\Uuids;

class OrgInvoiceSetting extends Model
{
    use Uuids;

    public $incrementing = false;

    protected $table = 'org_invoice_settings';

    protected $fillable = [
        'org_id', 'org_bank_account_id', 'paper_size', 'template', 'payment_advice', 'show_payment_advice'
    ];

    public function org()
    {
    	return $this->belongsTo('App\Models\Org');
    }

    public function bankAccount()
    {
    	return $this->belongsTo('App\Models\OrgBankAccount', 'org_bank_account_id');
    }
}
