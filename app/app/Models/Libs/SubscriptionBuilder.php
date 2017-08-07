<?php

namespace App\Models\Libs;

use App\Models\User;
use Carbon\Carbon;
use Mrfoh\Mulla\Api\Subscriptions;

class SubscriptionBuilder
{
    protected $owner;

    protected $skipTrial = false;

    protected $trialExpires;

    protected $plan;

    private $paystackSubscriptions;

    public function __construct(User $owner, Plan $plan)
    {
        $this->owner = $owner;
        $this->plan = $plan;
        $this->paystackSubscriptions = new Subscriptions();
    }

    protected function getPaystackCustomer(array $options)
    {
        if (! $this->owner->paystack_customer_code) {
            $customer = $this->owner->createPaystackCustomer($options);
        } else {
            $customer = $this->owner->asPaystackCustomer();
        }

        return $customer;
    }

    protected function getTrialEndForPayload()
    {
        if ($this->skipTrial) {
            return 'now';
        }

        if ($this->trialExpires) {
            return $this->trialExpires->getTimestamp();
        }
    }

    protected function buildSubscriptionPayload()
    {
        $payload = [
            'customer' => $this->owner->paystack_customer_code,
            'plan' => $this->plan->paystack_plan_code
        ];

        if ( !is_null($this->owner->authorization_code)) {
            $payload['authorization'] = $this->owner->authorization_code;
        }

        return $payload;
    }

    public function trialDays($trialDays)
    {
        $this->trialExpires = Carbon::now()->addDays($trialDays);

        return $this;
    }

    public function trialUntil(Carbon $trialUntil)
    {
        $this->trialExpires = $trialUntil;

        return $this;
    }

    public function skipTrial()
    {
        $this->skipTrial = true;

        return $this;
    }

    public function create(array $options)
    {
        $subscription = $this->paystackSubscriptions->create($this->buildSubscriptionPayload($options));

        if ($this->skipTrial) {
            $trialEndsAt = null;
        } else {
            $trialEndsAt = $this->trialExpires;
        }

        return $this->owner->subscriptions()->create([
            'user_id' => $this->owner->id,
            'plan_id' => $this->plan->id,
            'paystack_subscription_code' => $subscription['subscription_code'],
            'paystack_subscription_token' => $subscription['email_token'],
            'quantity' => 1,
            'trial_ends_at' => $trialEndsAt,
            'ends_at' => null
        ]);
    }
}