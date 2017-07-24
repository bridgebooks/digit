<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\Uuids;

class Role extends Model
{
    use Uuids;
    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    protected $guarded = [];

    protected $fillable = ['name', 'description', 'permissions'];

    public function users()
    {
      return $this->belongsToMany('App\Models\User', 'user_roles');
    }

    public function parent()
    {
        return $this->hasOne('App\Models\Role', 'parent_id', 'id');
    }

    /**
     * Get permissions attribute
     * @param string $value
     * @return object
     */
    public function getPermissionsAttribute($value)
    {
        return json_decode($value);
    }

    /**
     * set permissions attribute
     * @param string $value
     * @return void
     */
    public function setPermissionsAttribute($value)
    {   
        $this->attributes['permissions'] = json_encode($value);
    }
}
