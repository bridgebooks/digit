<?php

namespace App\Policies;

use App\Models\User;
use App\Models\OrgBankAccount;
use App\Traits\UserRequest;
use Illuminate\Auth\Access\HandlesAuthorization;

class OrgBankAccountPolicy
{
    use HandlesAuthorization, UserRequest;

    /**
     * Determine whether the user can create OrgBankAccount.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        $isOrgAdmin = $this->userHasRole('org_admin');
        $isOrgMember = $this->userHasRole('org_member');

        if ($isOrgAdmin || $isOrgMember) return true;

        return false;
    }

    /**
     * Determine whether the user can update the OrgBankAccount.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\OrgBankAccount $account
     * @return mixed
     */
    public function update(User $user, OrgBankAccount $account)
    {
        return $this->belongsToOrg($account->org_id);
    }

    /**
     * Determine whether the user can delete the OrgBankAccount.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\OrgBankAccount $account
     * @return mixed
     */
    public function delete(User $user, OrgBankAccount $account)
    {
        $belongsToOrg = $this->belongsToOrg($account->org_id);
        $isOrgAdmin = $this->userHasRole('org_admin');
        $isOrgMember = $this->userHasRole('org_member');

        if ($belongsToOrg) {
            if ($isOrgAdmin || $isOrgMember) {
                return true;
            }

            return false;
        }

        return false;
    }

    public function bulk(User $user)
    {
        $isOrgAdmin = $this->userHasRole('org_admin');
        $isOrgMember = $this->userHasRole('org_member');

        if ($isOrgAdmin || $isOrgMember) return true;

        return false;
    }
}
