<?php

namespace App\Models;

use Hash;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\Traits\Billable;
use App\Models\Traits\Uuids;

class User extends Authenticatable
{
    use Notifiable, Uuids, Billable;

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'email', 'phone', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'verification_token'
    ];

    public function subscriptions()
    {
      return $this->hasMany('App\Models\Subscription');
    }

    public function roles()
    {
      return $this->belongsToMany('App\Models\Role', 'user_roles');
    }

    public function orgs()
    {
      return $this->belongsToMany('App\Models\Org', 'org_users');
    }

    public function getVerificationToken()
    {
        return $this->verification_token;
    }

    /**
     * Verify user password
     * @param String $password
     */
    public function verifyPassword(String $password)
    {
        return Hash::check($password, $this->password);
    }
}
