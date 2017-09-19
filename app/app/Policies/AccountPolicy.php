<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Account;
use App\Traits\UserRequest;
use Illuminate\Auth\Access\HandlesAuthorization;

class AccountPolicy
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

    /**
     * Determine whether the user can create Account.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        $isOrgAdmin = $this->userHasRole('org_admin');
        $isOrgMember = $this->userHasRole('org_member');

        return $isOrgAdmin || $isOrgMember;
    }

    /**
     * Determine whether the user can update an Account.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function update(User $user, Account $account)
    {
        $isOrgAdmin = $this->userHasRole('org_admin');
        $isOrgMember = $this->userHasRole('org_member');
        $belongsTo = $this->belongsToOrg($account->org_id);

        return ($isOrgAdmin || $isOrgMember) && $belongsTo;
    }

    /**
     * Determine whether the user can delete an Account.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function delete(User $user, Account $account)
    {
        $isOrgAdmin = $this->userHasRole('org_admin');
        $isOrgMember = $this->userHasRole('org_member');
        $belongsTo = $this->belongsToOrg($account->org_id);

        return ($isOrgAdmin || $isOrgMember) && $belongsTo && !$account->is_system;
    }
}
