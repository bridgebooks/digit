<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Employee;
use App\Traits\UserRequest;
use Illuminate\Auth\Access\HandlesAuthorization;

class EmployeePolicy
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

    public function update(User $user, Employee $employee)
    {
        return $this->belongsToOrg($employee->org_id) || $this->isOwner($employee->user_id);
    }

    public function view(User $user, Employee $employee)
    {
        return $this->belongsToOrg($employee->org_id);
    }
}
