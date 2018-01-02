<?php

namespace App\Policies;

use App\Models\OrgPayrunSetting;
use App\Models\User;
use App\Traits\UserRequest;
use Illuminate\Auth\Access\HandlesAuthorization;

class OrgPayrunSettingPolicy
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
     * @param User $user
     * @param OrgPayrunSetting $setting
     * @return bool
     */
    public function view(User $user, OrgPayrunSetting $setting)
    {
        return $this->belongsToOrg($setting->org_id) && $this->can('payroll');
    }
}
