<?php

namespace App\Models;

use App\Models\Traits\Uuids;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * Class SubscriptionUsage.
 *
 * @package namespace App\Models;
 */
class SubscriptionUsage extends Model
{
    use Uuids;

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    public $table = 'subscription_usages';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'subscription_id',
        'feature_id'
    ];

    public function subscription()
    {
        return $this->belongsTo('App\Models\Subscription');
    }

    public function feature()
    {
        return $this->belongsTo('App\Models\PlanFeature');
    }

    /**
     * Scope subscription usage by feature name.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @param string $featureName
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByFeatureName(Builder $builder, string $featureName): Builder
    {
        $feature = PlanFeature::where('name', $featureName)->first();
        return $builder->where('feature_id', $feature->id ?? null);
    }
}
