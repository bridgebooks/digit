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

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'invoice_id',
        'row_order',
        'unit_price',
        'item_id',
        'account_id',
        'tax_rate_id',
        'description',
        'discount',
        'amount',
        'quantity'
    ];

    public function invoice() {
      return $this->belongsTo('App\Models\Invoice');
    }

    public function item() {
      return $this->belongsTo('App\Models\SalePurchaseItem', 'item_id');
    }

    public function account() {
      return $this->belongsTo('App\Models\Account');
    }

    public function taxRate() {
      return $this->belongsTo('App\Models\TaxRate', 'tax_rate_id');
    }
}
