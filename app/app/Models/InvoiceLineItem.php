<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\Uuids;

class InvoiceLineItem extends Model
{
    use Uuids;
    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    protected $table = "invoice_line_items";

    protected $guarded = [];

    protected $fillable = [
        'invoice_id'       
    ];

    public function invoice() {
      return $this->belongsTo('App\Models\Invoice');
    }

    public function item() {
      return $this->hasOne('App\Models\SalePurchaseItem', 'item_id');
    }

    public function account() {
      return $this->belongsTo('App\Models\Account');
    }

    public function taxRate() {
      return $this->hasOne('App\Models\TaxRate', 'tax_rate_id');
    }
}
