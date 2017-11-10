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

    protected $dates = ['trial_ends_at'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'card_brand', 
        'card_exp_month', 
        'card_last_four', 
        'card_exp_year', 
        'paystack_customer_code', 
        'password', 
        'remember_token', 
        'verification_token',
        'authorization_code'
    ];

    public function subscriptions()
    {
      return $this->hasMany('App\Models\Subscription');
    }

    public function roles()
    {
      return $this->belongsToMany('App\Models\Role', 'user_roles');
    }

    public function orgRoles()
    {
      return $this->belongsToMany('App\Models\OrgRole', 'org_user_roles', 'user_id', 'org_role_id');
    }

    public function orgs()
    {
      return $this->belongsToMany('App\Models\Org', 'org_users')->withPivot('status')->withTimestamps();
    }

    /**
    * Get user verification token
    * @return string
    */
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

    /**
     * Update user passsword
     * @param String $password
     * @return bool
     */
    public function updatePassword(String $password)
    {
        $this->password = Hash::make($password);
        return $this->save();
    }
}
