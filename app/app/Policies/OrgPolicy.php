<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Org;
use Illuminate\Auth\Access\HandlesAuthorization;

class OrgPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }
}
