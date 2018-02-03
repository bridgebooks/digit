<?php

namespace App\Listeners;

use App\Events\SubscriptionPaymentSuccess;
use App\Models\User;
use App\Repositories\PlanRepository;
use App\Repositories\UserRepository;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SubscriptionPaymentListener
{
    protected $users;

    protected $plans;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(UserRepository $users, PlanRepository $plans)
    {
        $this->users = $users;
        $this->plans = $plans;
    }

    private function updateUser(User $user, array $authorization)
    {
        $user->card_brand = substr($authorization['card_type'], 0, 4);
        $user->card_last_four = $authorization['last4'];
        $user->card_exp_month = $authorization['exp_month'];
        $user->card_exp_year = $authorization['exp_year'];
        $user->authorization_code = $authorization['authorization_code'];

        return $user->save();
    }

    /**
     * Handle the event.
     *
     * @param  SubscriptionPaymentSuccess  $event
     * @return void
     */
    public function handle(SubscriptionPaymentSuccess $event)
    {
        // get user
        $user = $this->users->skipPresenter()->findWhere(['email' => $event->email])->first();
        // get plan
        $plan = $this->plans->skipPresenter()->findWhere(['paystack_plan_code' => $event->planCode])->first();
        // update user
        if ($this->updateUser($user, $event->authorization)) {
            // create subscription
            $user->newSubscription($plan)
                ->skipTrial()
                ->create(['skip_paystack' => true ]);
        }
    }
}
