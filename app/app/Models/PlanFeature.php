<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\Uuids;

class PlanFeature extends Model
{
    use Uuids;
    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    protected $table = 'plan_features';

    protected $guarded = [];

    public function plan() {
      return $this->belongsTo('App\Models\Plan', 'plan_id');
    }
}
