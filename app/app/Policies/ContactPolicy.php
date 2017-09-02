<?php

namespace App\Policies;

use App\Traits\UserRequest;
use App\Models\User;
use App\Models\Contact;
use Illuminate\Auth\Access\HandlesAuthorization;

class ContactPolicy
{
    use HandlesAuthorization, UserRequest;

    /**
     * Determine whether the user can view the appModelsContact.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Contact $contact
     * @return mixed
     */
    public function view(User $user, Contact $contact)
    {
        return $user->id === $contact->user_id || $this->belongsToOrg($contact->org_id);
    }

    /**
     * Determine whether the user can create Contact.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the contact.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Contact $contact
     * @return mixed
     */
    public function update(User $user, Contact $contact)
    {
        return $this->belongsToOrg($contact->org_id);
    }

    /**
     * Determine whether the user can delete the Contact.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Contact $contact
     * @return mixed
     */
    public function delete(User $user, Contact $contact)
    {
        $belongsToOrg = $this->belongsToOrg($contact->org_id);
        $isOrgAdmin = $this->userHasRole('org_admin');
        $isOrgMember = $this->userHasRole('org_member');
        $isOwner = $contact->user_id === $user->id;

        if ($belongsToOrg) {
            if ($isOrgAdmin || $isOrgMember && $isOwner) {
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
