<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\Uuids;

class SubscriptionUsage extends Model
{
    use Uuids;
    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    protected $guarded = [];

    protected $table = "subscription_usages";

    public function feature()
    {
      return $this->belongsTo('App\Models\PlanFeature', 'feature_id');
    }
}
