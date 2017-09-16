<?php

namespace App\Policies;

use App\Traits\UserRequest;
use App\Models\User;
use App\Models\SalePurchaseItem;
use Illuminate\Auth\Access\HandlesAuthorization;

class SalePurchaseItemPolicy
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

    public function delete(User $user, SalePurchaseItem $item)
    {
        return $this->userHasRole('org_admin') || $this->userHasRole('org_member');
    }

    public function update(User $user, SalePurchaseItem $item)
    {
        return $this->userHasRole('org_admin') || $this->userHasRole('org_member');
    }
}
