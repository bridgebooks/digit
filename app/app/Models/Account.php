<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Traits\Uuids;

class Account extends Model
{
    use Uuids, SoftDeletes;
    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    protected $guarded = [];

    protected $dates = ['deleted_at'];

    protected $fillable = [
    	'is_system',
    	'account_type_id',
    	'org_id',
    	'code',
    	'name',
    	'description',
    	'tax_rate_id'
    ];

    public function type()
    {
      return $this->belongsTo('App\Models\AccountType', 'account_type_id');
    }

    public function taxRate()
    {
      return $this->belongsTo('App\Models\TaxRate');
    }
}
