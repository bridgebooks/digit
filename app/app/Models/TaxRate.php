<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\Uuids;

class TaxRate extends Model
{
    use Uuids;
    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    protected $table = "tax_rates";

    protected $guarded = [];

    public function components() {
      return $this->hasMany('App\Models\TaxRateComponent', 'tax_rate_id');
    }
}
