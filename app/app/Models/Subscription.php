<?php

namespace App\Models;

use App\Models\Libs\Period;
use App\Models\Traits\Subscribable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\Uuids;

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

    /**
     * Mark the subscription as cancelled.
     *
     * @return void
     */
    public function markAsCancelled()
    {
        $this->fill(['canceled_at' => Carbon::now()])->save();
    }

    public function cancelTrial()
    {
        if ($this->onTrial()) {
            $this->ends_at = null;
            $this->trial_ends_at = null;
            $this->save();
        }
    }
}
