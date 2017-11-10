<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Traits\Uuids;

class InvoicePayment extends Model
{
    use Uuids, SoftDeletes;

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    protected $guarded = [];

    protected $dates = ['deleted_at', 'paid_at'];

    protected $fillable = [
    	'invoice_id',
        'medium',
    	'transaction_ref',
    	'processor_transaction_ref',
    	'amount',
    	'processor_fee',
    	'fee',
    	'first_name',
    	'last_name',
    	'phone',
    	'email',
    	'status',
        'paid_at'
    ];

    public function invoice()
    {
        return $this->belongsTo('App\Models\Invoice');
    }
}
