<?php

namespace App\Models\Observers;

use App\Models\User;
use App\Traits\UserRequest;

class UserObserver
{
    use UserRequest;
    /**
     * Listen to the User creating event.
     *
     * @param  User  $user
     * @return void
     */
    public function creating(User $user)
    {
        $string = bin2hex(random_bytes(16)); // 20 chars
        $user->verification_token = $string;
    }

    public function deleted(User $user)
    {
        $requestUser = $this->requestUser();
        $subscription = $requestUser->getActiveSubscription() ?? $requestUser->getOrgActiveSubscription();

        $subscription->reduceFeatureUsage('users');
    }
}