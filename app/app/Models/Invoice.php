<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Traits\Uuids;

class Invoice extends Model
{
    use SoftDeletes, Uuids;
    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    protected $guarded = [];

    protected $dates = ['deleted_at'];

    protected $fillable = [
      'org_id', 'user_id', 'type','contact_id','invoice_no','reference','due_at','line_amount_type', 'currency_id', 'status'
    ];

    public function items() {
      return $this->hasMany('App\Models\InvoiceLineItem');
    }

    public function currency() {
      return $this->hasOne('App\Models\Currency', 'currency_id');
    }
}
