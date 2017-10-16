<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\Uuids;

class OrgRole extends Model
{
    use Uuids;

    public $incrementing = false;

    /**
     * The table name.
     *
     * @var array
     */
    protected $table = 'org_roles';


    protected $fillable = [
        'org_id', 'name', 'short_description', 'description', 'permissions'
    ];

    public function org()
    {
    	return $this->belongsTo('App\Models\Org');
    }

    public function users()
    {
    	return $this->belongsToMany('App\Models\User', 'org_user_roles', 'user_id', 'org_role_id');
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
