<?php

namespace App\Policies;

use App\Traits\UserRequest;
use App\Models\User;
use App\Models\ContactGroup;
use Illuminate\Auth\Access\HandlesAuthorization;

class ContactGroupPolicy
{
    use HandlesAuthorization, UserRequest;

    /**
     * Determine whether the user can view the ContactGroups
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function list(User $user)
    {
       return $this->userHasRole('org_admin') || $this->userHasRole('org_member');
    }

    /**
     * Determine whether the user can create ContactGroup.
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
     * Determine whether the user can update the contact.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ContactGroup $contactGroup
     * @return mixed
     */
    public function update(User $user, ContactGroup $contactGroup)
    {
        return $this->belongsToOrg($contactGroup->org_id);
    }

    /**
     * Determine whether the user can delete the ContactGroup.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ContactGroup $contactGroup
     * @return mixed
     */
    public function delete(User $user, ContactGroup $contactGroup)
    {
        $belongsToOrg = $this->belongsToOrg($contactGroup->org_id);
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
}
