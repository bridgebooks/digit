<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\Traits\Uuids;

class User extends Authenticatable
{
    use Notifiable, Uuids;

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
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function subscription()
    {
      return $this->hasOne('App\Models\Subscription');
    }

    public function roles()
    {
      return $this->belongsToMany('App\Models\Role', 'user_roles');
    }

    public function orgs()
    {
      return $this->belongsToMany('App\Models\Org', 'org_users');
    }
}
