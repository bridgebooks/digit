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

    public function transactions()
    {
        return $this->hasMany('App\Models\Transaction', 'account_id');
    }

    public function updateYTD()
    {
    }

    /**
     * Scope a query to only include users of a given type.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $name
     * @param string $id
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByName($query, string $name, string $id)
    {
        return $query->where('org_id', $id)->where('name', 'LIKE', '%' . $name . '%');
    }
}
