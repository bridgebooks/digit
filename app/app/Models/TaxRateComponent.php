<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\Uuids;

class TaxRateComponent extends Model
{
    use Uuids;
    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    protected $table = "tax_rate_components";

    protected $guarded = [];

    public function taxRate() {
      return $this->belongsTo('App\Models\TaxRate', 'tax_rate_id');
    }
}
