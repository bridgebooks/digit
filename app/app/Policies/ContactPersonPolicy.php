<?php

namespace App\Policies;

use App\Models\User;
use App\Models\ContactPerson;
use App\Traits\UserRequest;
use Illuminate\Auth\Access\HandlesAuthorization;

class ContactPersonPolicy
{
    use HandlesAuthorization, UserRequest;

    private function hasOrgPermissions(ContactPerson $contactPerson)
    {
        $hasRole = $this->userHasRole('org_admin') || $this->userHasRole('org_member');
        $org_id = $contactPerson->contact->org_id;
        $belongsToOrg = $this->belongsToOrg($org_id);

        return $hasRole && $belongsToOrg;
    }

    /**
     * Determine whether the user can view the contactPerson.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ContactPerson  $contactPerson
     * @return mixed
     */
    public function view(User $user, ContactPerson $contactPerson)
    {
        //
    }

    /**
     * Determine whether the user can create contactPeople.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the contactPerson.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ContactPerson  $contactPerson
     * @return mixed
     */
    public function update(User $user, ContactPerson $contactPerson)
    {
        return $this->hasOrgPermissions($contactPerson);
    }

    /**
     * Determine whether the user can delete the contactPerson.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ContactPerson  $contactPerson
     * @return mixed
     */
    public function delete(User $user, ContactPerson $contactPerson)
    {
        return $this->hasOrgPermissions($contactPerson);
    }
}
