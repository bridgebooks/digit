<?php

namespace App\Policies;

use App\Models\OrgAccountSetting;
use App\Models\User;
use App\Traits\UserRequest;
use Illuminate\Auth\Access\HandlesAuthorization;

class OrgAccountSettingPolicy
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
     * @param OrgAccountSetting $setting
     * @return bool
     */
    public function view(User $user, OrgAccountSetting $setting)
    {
        return $this->belongsToOrg($setting->org_id) && $this->can('settings.accounts');
    }
}
