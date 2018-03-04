<?php

namespace App\Listeners;

use App\Repositories\UserRepository;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class PaystackSubscriptionEventSubscriber implements ShouldQueue
{
    use InteractsWithQueue;

    private $users;

    public function __construct(UserRepository $users)
    {
        $this->users = $users;
    }

    /**
     * @param string $customerCode
     * @return mixed
     */
    private function getUser(string $customerCode)
    {
        return $this->users
            ->skipPresenter()
            ->findWhere([
                'paystack_customer_code' => $customerCode
            ])
            ->first();
    }

    /**
     * @param $event
     */
    public function onSubscriptionCreated($event)
    {
        // get user
        $user = $this->getUser($event->data['customer']['customer_code']);
        // get active subscription
        $subscription = $user->getActiveSubscription();

        if ($subscription) {
            if (
                is_null($subscription->paystack_subscription_code) ||
                is_null($subscription->paystack_subscription_token)
            ) {
                $subscription->paystack_subscription_code = $event->data['subscription_code'];
                $subscription->paystack_subscription_token = $event->data['email_token'];
                $subscription->save();
            }
        } else {
            $lastSubscription = $user->getLastActiveSubscription();
            if ($lastSubscription) {
                $user->newSubscription($lastSubscription->plan)
                    ->skipTrial()
                    ->create();
            }
        }

        $this->delete();
    }

    /**
     * @param $event
     */
    public function onSubscriptionEnabled($event)
    {
        // get user
        $user = $this->getUser($event->data['customer']['customer_code']);
        // get active subscription
        $subscription = $user->getActiveSubscription();

        \Log::info('event', $event->data);

        $this->delete();
    }

    /**
     * @param $event
     */
    public function onSubscriptionDisabled($event)
    {
        // get user
        $user = $this->getUser($event->data['customer']['customer_code']);
        // get active subscription
        $subscription = $user->getActiveSubscription();

        \Log::info('event', $event->data);

        $this->delete();
    }

    public function subscribe($events)
    {
        $events->listen(
          'App\Events\Paystack\SubscriptionCreated',
          'App\Listeners\PaystackSubscriptionEventSubscriber@onSubscriptionCreated'
        );

        $events->listen(
            'App\Events\Paystack\SubscriptionEnabled',
            'App\Listeners\PaystackSubscriptionEventSubscriber@onSubscriptionEnabled'
        );

        $events->listen(
            'App\Events\Paystack\SubscriptionDisabled',
            'App\Listeners\PaystackSubscriptionEventSubscriber@onSubscriptionEnabled'
        );
    }
}