<?php

namespace App\Models;

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

    protected $fillable = [ 'name', 'compound', 'value' ];

    public function tax() 
    {
      return $this->belongsTo('App\Models\Tax', 'tax_rate_id');
    }
}
