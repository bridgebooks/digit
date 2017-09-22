<?php

namespace App\Policies;

use App\Models\User;
use App\Models\TaxRate;
use App\Traits\UserRequest;
use Illuminate\Auth\Access\HandlesAuthorization;

class TaxRatePolicy
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
     * Determine whether the user can create TaxRate.
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
     * Determine whether the user can update an TaxRate.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function update(User $user, TaxRate $taxRate)
    {
        $isOrgAdmin = $this->userHasRole('org_admin');
        $isOrgMember = $this->userHasRole('org_member');
        $belongsTo = $this->belongsToOrg($taxRate->org_id);

        return ($isOrgAdmin || $isOrgMember) && $belongsTo;
    }

    /**
     * Determine whether the user can delete an TaxRate.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function delete(User $user, TaxRate $taxRate)
    {
        $isOrgAdmin = $this->userHasRole('org_admin');
        $isOrgMember = $this->userHasRole('org_member');
        $belongsTo = $this->belongsToOrg($taxRate->org_id);

        return ($isOrgAdmin || $isOrgMember) && $belongsTo && !$taxRate->is_system;
    }

    public function bulk(User $user)
    {
        $isOrgAdmin = $this->userHasRole('org_admin');

        if ($isOrgAdmin) return true;

        return false;
    }
}
