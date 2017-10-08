<?php

namespace App\Policies;

use App\Models\User;
use App\Models\OrgInvoiceSetting;
use App\Traits\UserRequest;
use Illuminate\Auth\Access\HandlesAuthorization;

class OrgInvoiceSettingPolicy
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

    public function update(User $user, OrgInvoiceSetting $settings)
    {
        $isAdmin = $this->userHasRole('org_admin');
        $belongsToOrg = $this->belongsToOrg($settings->org_id);

        return $isAdmin && $belongsToOrg;
    }
}
