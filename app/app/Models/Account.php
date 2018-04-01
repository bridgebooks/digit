<?php

namespace App\Models;

use Carbon\Carbon;
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

    public function scopeByType($query, string $type)
    {
        return $query->whereHas('type', function ($qb) use ($type) {
            $qb->where('name', $type);
        });
    }

    public function getYTDbalance(Carbon $start, Carbon $end)
    {

        $transactions = $this->transactions()
            ->whereBetween('created_at', [
                $start->startOfDay()->toDateTimeString(),
                $end->endOfDay()->toDateTimeString()
            ])
            ->get();

        $debits = $transactions->map(function ($transaction) {
            return $transaction->debit;
        })->sum();

        $credits = $transactions->map(function ($transaction) {
            return $transaction->credit;
        })->sum();

        if ($this->type->normal_balance === "credit") {
            $ytd = $credits - $debits;
        } else {
            $ytd = $debits - $credits;
        }

        return $ytd;
    }
}
