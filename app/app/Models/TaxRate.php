<?php

namespace App\Models;

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

    protected $fillable = [ 'name', 'org_id', 'is_system',  ];

    public function components() 
    {
      return $this->hasMany('App\Models\TaxRateComponent', 'tax_rate_id');
    }

    public function accounts()
    {
        return $this->hasMany('App\Models\Account', 'tax_rate_id');
    }
}
