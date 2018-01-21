<?php

namespace App\Models;

use App\Models\Libs\Period;
use App\Models\Traits\Subscribable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\Uuids;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Subscription extends Model
{
    use Uuids, Subscribable;
    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;


    protected $guarded = [];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'trial_ends_at',
        'ends_at',
        'starts_at',
        'canceled_at',
        'cancels_at'
    ];

    public $fillable = [
        'plan_id',
        'user_id',
        'paystack_subscription_code',
        'paystack_subscription_token',
        'quantity',
        'trial_ends_at',
        'ends_at',
        'starts_at',
        'canceled_at',
        'cancels_at'
    ];

    public function owner()
    {
      return $this->belongsTo('App\Models\User');
    }

    public function plan()
    {
      return $this->belongsTo('App\Models\Plan');
    }

    public function usage()
    {
        return $this->hasMany('App\Models\SubscriptionUsage');
    }

    /**
     * Cancel subscription.
     *
     * @param bool $immediately
     *
     * @return $this
     */
    public function cancel($immediately = false)
    {
        $this->canceled_at = Carbon::now();
        if ($immediately) {
            $this->ends_at = $this->canceled_at;
        }
        $this->save();

        return $this;
    }

    /**
     * Determine if the subscription is active.
     *
     * @return bool
     */
    public function active()
    {
        return ! $this->ended() || $this->onTrial();
    }

    /**
     * Check if subscription is inactive.
     *
     * @return bool
     */
    public function inactive()
    {
        return ! $this->active();
    }

    /**
     * Determine if the subscription is within its trial period.
     *
     * @return bool
     */
    public function onTrial()
    {
        return $this->trial_ends_at ? Carbon::now()->lt($this->trial_ends_at) : false;
    }

    /**
     * Determine if the subscription is within its grace period after cancellation.
     *
     * @return bool
     */
    public function onGracePeriod()
    {
        if (! is_null($endsAt = $this->ends_at)) {
            return Carbon::now()->lt(Carbon::instance($endsAt));
        } else {
            return false;
        }
    }

    /**
     * Check if subscription is canceled.
     *
     * @return bool
     */
    public function canceled(): bool
    {
        return $this->canceled_at ? Carbon::now()->gte($this->canceled_at) : false;
    }

    /**
     * Check if subscription period has ended.
     *
     * @return bool
     */
    public function ended()
    {
        return $this->ends_at ? Carbon::now()->gte($this->ends_at) : false;
    }


    public function cancelTrial()
    {
        if ($this->onTrial()) {
            $this->ends_at = null;
            $this->trial_ends_at = null;
            $this->save();
        }
    }

    /**
     * Get feature value.
     *
     * @param string $featureSlug
     *
     * @return mixed
     */
    public function getFeatureValue(string $featureName)
    {
        $feature = $this->plan->features()->where('name', $featureName)->first();
        return $feature->value ?? null;
    }

    /**
     * Get how many times the feature has been used.
     *
     * @param string $featureName
     *
     * @return int
     */
    public function getFeatureUsage(string $featureName): int
    {
        $usage = $this->usage()->byFeatureName($featureName)->first();
        return $usage ? $usage->used : 0;
    }

    /**
     * Get the available uses.
     *
     * @param string $featureName
     *
     * @return int
     */
    public function getFeatureRemainings(string $featureName): int
    {
        $value = $this->getFeatureValue($featureName);
        $usage = $this->getFeatureUsage($featureName);

        return (int) $value - (int) $usage;
    }

    /**
     * @param string $featureName
     * @param int $uses
     * @param bool $incremental
     * @return SubscriptionUsage
     */
    public function recordFeatureUsage(string $featureName, int $uses = 1, bool $incremental = true): SubscriptionUsage
    {
        $feature = $this->plan->features()->where('name', $featureName)->first();

        $usage = $this->usage()->firstOrNew([
            'subscription_id' => $this->id,
            'feature_id' => $feature->id
        ]);

        $usage->used = ($incremental) ? $usage->used + $uses : $uses;

        $usage->save();

        return $usage;
    }

    /**
     * Decrement a feature usage
     * @param string $featureName
     * @param int $uses
     */
    public function reduceFeatureUsage(string $featureName, int $uses = 1)
    {
        $usage = $this->usage()->byFeatureName($featureName)->first();
        if (is_null($usage)) {
            return;
        }
        $usage->used = max($usage->used - $uses, 0);
        $usage->save();
        return $usage;
    }

    public function canUseFeature(string $featureName): bool
    {
        $featureValue = $this->getFeatureValue($featureName);
        // $usage = $this->usage()->byFeatureName($featureName)->first();
        $valueIsNumber = is_numeric($featureValue);
        $valuesIsBool = is_bool($featureValue);

        $featureValue = $valueIsNumber ? (int) $featureValue : (bool) $featureValue;

        if ($valuesIsBool && $featureValue) return true;

        if ($valuesIsBool && !$featureValue) return false;

        if ($valueIsNumber && $featureValue === -1) return true;

        return ($valueIsNumber && $featureValue > 0)
            ? $this->getFeatureRemainings($featureName) > 0
            : false;
    }
}
