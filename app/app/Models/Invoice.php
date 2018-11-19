<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Traits\Uuids;
use Laravel\Scout\Searchable;

class Invoice extends Model
{
    use SoftDeletes, Uuids, Searchable;
    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    protected $guarded = [];

    protected $dates = ['deleted_at', 'due_at', 'raised_at'];

    protected $fillable = [
      'org_id', 
      'user_id', 
      'type', 
      'contact_id', 
      'invoice_no', 
      'reference',
      'raised_at',  
      'due_at',
      'sub_total',
      'tax_total',
      'total',
      'line_amount_type',
      'currency_id',
      'status',
      'notes',
      'pdf_url'
    ];

    public function user() {
      return $this->belongsTo('App\Models\User');
    }

    public function org() {
      return $this->belongsTo('App\Models\Org');
    }

    public function contact() {
      return $this->belongsTo('App\Models\Contact');
    }

    public function items() {
      return $this->hasMany('App\Models\InvoiceLineItem');
    }

    public function currency() {
      return $this->hasOne('App\Models\Currency', 'currency_id');
    }

    public function payment()
    {
        return $this->hasOne('App\Models\InvoicePayment');
    }

    public function scopeOfOrg($query, string $id)
    {
        return $query->where('org_id', $id);
    }

    public function scopeNotStatus($query, array $status)
    {
        return $query->whereNotIn('status', $status);
    }

    public function scopeOfTypeBetween($query, string $type, Carbon $start, Carbon $end)
    {
        return $query->where('type', $type)
            ->whereBetween('created_at', [
                $start->toDateTimeString(),
                $end->toDateTimeString()
            ]);
    }
}
