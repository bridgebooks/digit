<?php

namespace App\Policies;

use App\Models\PayItem;
use App\Models\User;
use App\Traits\UserRequest;
use Illuminate\Auth\Access\HandlesAuthorization;

class PayitemPolicy
{
    use HandlesAuthorization, UserRequest;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function update(User $user, PayItem $payItem)
    {
        return $this->belongsToOrg($payItem->org_id);
    }

    public function archive(User $user, PayItem $payItem)
    {
        return $this->belongsToOrg($payItem->org_id);
    }

    public function delete(User $user, PayItem $payItem)
    {
        return $this->belongsToOrg($payItem->org_id);
    }
}
