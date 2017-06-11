<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\Uuids;

class Account extends Model
{
    use Uuids;
    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    protected $guarded = [];

    public function type()
    {
      return $this->belongsTo('App\Models\AccountType', 'account_type_id');
    }

    public function taxRate()
    {
      return $this->hasOne('App\Models\TaxRate', 'tax_rate_id');
    }
}
