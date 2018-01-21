<?php

namespace App\Policies;

use App\Models\User;
use App\Traits\UserRequest;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
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

    public function remove(User $user, User $toRemove)
    {
        return $this->userHasRole('org_admin');
    }
}
