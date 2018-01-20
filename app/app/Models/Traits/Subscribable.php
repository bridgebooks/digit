<?php

namespace App\Models\Traits;

use Mrfoh\Mulla\Api\Subscriptions;

trait Subscribable {

    protected $paystackSubscription = null;

    private function getPaystackSubscriptionInstance() {
        if (is_null($this->paystackSubscription)) {
            $this->paystackSubscription = new Subscriptions();
        }

        return $this->paystackSubscription;
    }

    /**
     * Disable paystack subscription
     * @return bool
     */
    public function disablePaystackSubscription()
    {
        $subscription = $this->getPaystackSubscriptionInstance();

        $disable =  $subscription->disable($this->paystack_subscription_code, $this->paystack_subscription_token);

        return $disable['status'] || $disable['status'] === true ? true : false;
    }
}