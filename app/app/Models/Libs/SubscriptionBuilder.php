<?php

namespace App\Models\Libs;

use App\Models\User;
use App\Models\Plan;
use Carbon\Carbon;
use Mrfoh\Mulla\Api\Subscriptions;

class SubscriptionBuilder
{
    protected $owner;

    protected $skipTrial = false;

    protected $plan;

    private $paystackSubscriptions;

    /**
     * SubscriptionBuilder constructor.
     * @param User $owner
     * @param Plan $plan
     */
    public function __construct(User $owner, Plan $plan)
    {
        $this->owner = $owner;
        $this->plan = $plan;
        $this->paystackSubscriptions = new Subscriptions();

        return $this;
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


    public function skipTrial()
    {
        $this->skipTrial = true;

        return $this;
    }

    /**
     * @param array $options
     * @return \Illuminate\Database\Eloquent\Model
     * @throws \Mrfoh\Mulla\Exceptions\InvalidRequestException
     * @throws \Mrfoh\Mulla\Exceptions\InvalidResponseException
     */
    public function create(array $options = [ 'skip_paystack' => false ])
    {
        !$options['skip_paystack']
            ? $subscription = $this->paystackSubscriptions->create($this->buildSubscriptionPayload())
            : $subscription = null;

       $trial = !$this->skipTrial
            ? new Period($this->plan->trial_interval, $this->plan->trial_period, new Carbon())
            : null;
        $period = $trial
            ? new Period($this->plan->invoice_interval, $this->plan->invoice_period, $trial->getEndDate())
            : new Period($this->plan->invoice_interval, $this->plan->invoice_period);

        return $this->owner->subscriptions()->create([
            'user_id' => $this->owner->id,
            'plan_id' => $this->plan->id,
            'paystack_subscription_code' => !is_null($subscription) ? $subscription['subscription_code'] : null,
            'paystack_subscription_token' => !is_null($subscription) ? $subscription['email_token'] : null,
            'quantity' => 1,
            'trial_ends_at' => $trial ? $trial->getEndDate() : null,
            'starts_at' => $trial ? $trial->getStartDate() : $period->getStartDate(),
            'ends_at' => $trial ? $trial->getEndDate() : $period->getEndDate()
        ]);
    }
}