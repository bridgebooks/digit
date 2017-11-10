<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Invoice;
use App\Traits\UserRequest;
use Illuminate\Auth\Access\HandlesAuthorization;

class InvoicePolicy
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
     * Determine whether the user can create an invoice
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
     * Determine whether the user can update an invoice
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function update(User $user, Invoice $invoice)
    {
        $isOrgAdmin = $this->userHasRole('org_admin');
        $isOrgMember = $this->userHasRole('org_member');
        return $isOrgAdmin || $isOrgMember;
    }

    public function send(User $user, Invoice $invoice)
    {
        $isOrgAdmin = $this->userHasRole('org_admin');
        $isOrgMember = $this->userHasRole('org_member');

        return $isOrgAdmin || $isOrgMember;   
    }

}
